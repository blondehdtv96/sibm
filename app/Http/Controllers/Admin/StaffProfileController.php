<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaffProfile;
use App\Models\StaffProfileImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StaffProfileController extends Controller
{
    private const CATEGORIES = [
        'Guru', 'Tenaga Kependidikan', 'Kepala Sekolah', 'Wakil Kepala Sekolah',
        'Kaprog', 'Guru Produktif', 'Guru Normatif', 'Guru Adaptif', 'Staff TU', 'Lainnya',
    ];

    private const EMPLOYMENT_STATUSES = ['ASN', 'Honorer', 'Kontrak', 'Tetap', 'Kepala Sekolah', 'Waka', 'Kaprog'];

    public function index(Request $request)
    {
        $query = StaffProfile::query();
        if ($request->boolean('trash')) $query->onlyTrashed();
        $staffProfiles = $query->search($request->input('search'))
            ->when($request->filled('category'), fn ($q) => $q->where('category', $request->category))
            ->when($request->filled('jurusan'), fn ($q) => $q->where('jurusan', 'like', '%' . $request->jurusan . '%'))
            ->when($request->filled('employment_status'), fn ($q) => $q->where('employment_status', $request->employment_status))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->withCount('images')->ordered()->paginate(15)->withQueryString();

        return response()
            ->view('admin.staff-profiles.index', [
                'staffProfiles' => $staffProfiles,
                'categories' => self::CATEGORIES,
                'employmentStatuses' => self::EMPLOYMENT_STATUSES,
                'isTrash' => $request->boolean('trash'),
            ])
            ->header('Cache-Control', 'no-store, must-revalidate');
    }

    public function create()
    {
        return view('admin.staff-profiles.create', $this->formOptions());
    }

    public function store(Request $request)
    {
        $validated = $this->validateProfile($request);
        $validated['slug'] = StaffProfile::generateUniqueSlug($validated['name']);
        $validated['sort_order'] = $validated['sort_order'] ?? ((int) StaffProfile::withTrashed()->max('sort_order') + 1);
        $validated['is_featured'] = $request->boolean('is_featured');

        DB::transaction(function () use ($request, &$validated) {
            if ($request->hasFile('photo')) $validated['photo'] = $this->storeImage($request->file('photo'));
            $profile = StaffProfile::create($validated);
            $this->storeGalleryImages($request, $profile);
        });

        return redirect()->route('admin.staff-profiles.index')->with('success', 'Profil berhasil ditambahkan.');
    }

    public function show(StaffProfile $staffProfile)
    {
        $staffProfile->load('images');
        return response()
            ->view('admin.staff-profiles.show', compact('staffProfile'))
            ->header('Cache-Control', 'no-store, must-revalidate');
    }

    public function edit(StaffProfile $staffProfile)
    {
        $staffProfile->load('images');
        return view('admin.staff-profiles.edit', array_merge(['staffProfile' => $staffProfile], $this->formOptions()));
    }

    public function update(Request $request, StaffProfile $staffProfile)
    {
        $validated = $this->validateProfile($request, $staffProfile);
        $validated['slug'] = StaffProfile::generateUniqueSlug($validated['name'], $staffProfile->id);
        $validated['sort_order'] = $validated['sort_order'] ?? $staffProfile->sort_order;
        $validated['is_featured'] = $request->boolean('is_featured');
        $newPhoto = null;

        DB::transaction(function () use ($request, $staffProfile, &$validated, &$newPhoto) {
            if ($request->hasFile('photo')) {
                $newPhoto = $this->storeImage($request->file('photo'));
                $validated['photo'] = $newPhoto;
            }
            $oldPhoto = $staffProfile->photo;
            $staffProfile->update($validated);
            $this->storeGalleryImages($request, $staffProfile);
            if ($newPhoto && $oldPhoto) Storage::disk('public')->delete($oldPhoto);
        });

        return redirect()->route('admin.staff-profiles.index')->with('success', 'Profil berhasil diperbarui.');
    }

    public function destroy(StaffProfile $staffProfile)
    {
        $staffProfile->delete();
        return redirect()->route('admin.staff-profiles.index')->with('success', 'Profil dipindahkan ke tempat sampah.');
    }

    public function trash(Request $request)
    {
        $request->merge(['trash' => true]);
        return $this->index($request);
    }

    public function restore($staffProfile)
    {
        StaffProfile::withTrashed()->where('slug', $staffProfile)->firstOrFail()->restore();
        return redirect()->route('admin.staff-profiles.trash')->with('success', 'Profil berhasil dipulihkan.');
    }

    public function forceDestroy($staffProfile)
    {
        $profile = StaffProfile::withTrashed()->with('images')->where('slug', $staffProfile)->firstOrFail();
        if ($profile->photo) Storage::disk('public')->delete($profile->photo);
        foreach ($profile->images as $image) {
            Storage::disk('public')->delete([$image->image_path, $image->thumbnail_path]);
        }
        $profile->forceDelete();
        return redirect()->route('admin.staff-profiles.trash')->with('success', 'Profil dihapus permanen.');
    }

    public function deleteGalleryImage(StaffProfile $staffProfile, StaffProfileImage $image)
    {
        abort_unless($image->staff_profile_id === $staffProfile->id, 404);
        Storage::disk('public')->delete([$image->image_path, $image->thumbnail_path]);
        $image->delete();
        return back()->with('success', 'Foto kegiatan dihapus.');
    }

    public function exportCsv()
    {
        $filename = 'profil-guru-tenaga-kependidikan-' . now()->format('Ymd-His') . '.csv';
        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Nama', 'Gelar Depan', 'Gelar Belakang', 'NIP', 'NUPTK', 'Jabatan', 'Kategori', 'Jurusan', 'Mapel', 'Status Kepegawaian', 'Email', 'Telepon', 'Status']);
            StaffProfile::ordered()->chunk(200, function ($profiles) use ($handle) {
                foreach ($profiles as $profile) {
                    fputcsv($handle, [$profile->name, $profile->gelar_depan, $profile->gelar_belakang, $profile->nip, $profile->nuptk, $profile->position, $profile->category, $profile->jurusan, $profile->subjects, $profile->employment_status, $profile->email, $profile->phone, $profile->status]);
                }
            });
            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function importCsv(Request $request)
    {
        $request->validate(['file' => ['required', 'file', 'mimes:csv,txt', 'max:5120']]);
        $handle = fopen($request->file('file')->getRealPath(), 'r');
        $header = fgetcsv($handle);
        $imported = 0;

        while (($row = fgetcsv($handle)) !== false) {
            $row = array_pad($row, 13, '');
            $name = trim((string) $row[0]);
            if ($name === '') continue;

            $nip = trim((string) $row[3]);
            $profileQuery = StaffProfile::withTrashed();
            $profile = $nip !== ''
                ? $profileQuery->where('nip', $nip)->first()
                : $profileQuery->where('name', $name)->first();

            $attributes = [
                'name' => $name,
                'gelar_depan' => trim((string) $row[1]) ?: null,
                'gelar_belakang' => trim((string) $row[2]) ?: null,
                'nip' => $nip ?: null,
                'nuptk' => trim((string) $row[4]) ?: null,
                'position' => trim((string) $row[5]) ?: 'Guru',
                'category' => trim((string) $row[6]) ?: 'Guru',
                'jurusan' => trim((string) $row[7]) ?: null,
                'subjects' => trim((string) $row[8]) ?: null,
                'employment_status' => trim((string) $row[9]) ?: null,
                'email' => trim((string) $row[10]) ?: null,
                'phone' => trim((string) $row[11]) ?: null,
                'status' => trim((string) $row[12]) ?: 'active',
            ];

            if (!$profile) {
                $profile = new StaffProfile();
                $attributes['slug'] = StaffProfile::generateUniqueSlug($name);
            } elseif (blank($profile->slug)) {
                $attributes['slug'] = StaffProfile::generateUniqueSlug($name, $profile->id);
            }

            $profile->fill($attributes)->save();
            $imported++;
        }
        fclose($handle);
        return back()->with('success', $imported . ' profil berhasil diimpor.');
    }

    private function formOptions(): array
    {
        return ['categories' => self::CATEGORIES, 'employmentStatuses' => self::EMPLOYMENT_STATUSES];
    }

    private function validateProfile(Request $request, ?StaffProfile $profile = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'gelar_depan' => ['nullable', 'string', 'max:50'], 'gelar_belakang' => ['nullable', 'string', 'max:100'],
            'nip' => ['nullable', 'string', 'max:50'], 'nuptk' => ['nullable', 'string', 'max:50'],
            'gender' => ['nullable', 'string', 'max:30'], 'religion' => ['nullable', 'string', 'max:50'],
            'birth_place' => ['nullable', 'string', 'max:100'], 'birth_date' => ['nullable', 'date', 'before:today'],
            'position' => ['required', 'string', 'max:255'], 'category' => ['required', 'string', 'max:100'],
            'jurusan' => ['nullable', 'string', 'max:255'], 'subjects' => ['nullable', 'string', 'max:255'],
            'employment_status' => ['nullable', 'string', 'max:100'], 'bio' => ['nullable', 'string', 'max:5000'],
            'email' => ['nullable', 'email', 'max:255'], 'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:1000'], 'education' => ['nullable', 'string', 'max:255'],
            'education_history' => ['nullable', 'string', 'max:5000'], 'certifications' => ['nullable', 'string', 'max:5000'],
            'competencies' => ['nullable', 'string', 'max:5000'], 'experience' => ['nullable', 'string', 'max:5000'],
            'achievements' => ['nullable', 'string', 'max:5000'], 'motto' => ['nullable', 'string', 'max:1000'],
            'facebook' => ['nullable', 'url', 'max:255'], 'instagram' => ['nullable', 'url', 'max:255'],
            'linkedin' => ['nullable', 'url', 'max:255'], 'youtube' => ['nullable', 'url', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'], 'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:10240'],
            'gallery_images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:10240'],
            'gallery_captions.*' => ['nullable', 'string', 'max:255'], 'sort_order' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:active,inactive'], 'is_featured' => ['nullable', 'boolean'],
        ]);
    }

    private function storeImage($file): string
    {
        return $file->store('staff-profiles', 'public');
    }

    private function storeGalleryImages(Request $request, StaffProfile $profile): void
    {
        if (!$request->hasFile('gallery_images')) return;
        $order = (int) ($profile->images()->max('sort_order') ?? -1);
        foreach ($request->file('gallery_images') as $index => $file) {
            $path = $this->storeImage($file);
            StaffProfileImage::create([
                'staff_profile_id' => $profile->id, 'image_path' => $path,
                'caption' => $request->input('gallery_captions.' . $index), 'sort_order' => ++$order,
            ]);
        }
    }
}
