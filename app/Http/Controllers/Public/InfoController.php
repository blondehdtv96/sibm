<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class InfoController extends Controller
{
    /**
     * Display the about/profile page.
     */
    public function about()
    {
        return view('public.info.about');
    }

    /**
     * Display the contact page.
     */
    public function contact()
    {
        return view('public.info.contact');
    }

    /**
     * Handle contact form submission.
     */
    public function sendContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // Save to database
        ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'ip_address' => $request->ip(),
        ]);
        
        return back()->with('success', 'Terima kasih! Pesan Anda telah terkirim. Kami akan segera menghubungi Anda.');
    }

    /**
     * Display the school overview page.
     */
    public function overview()
    {
        try {
            $overview = Setting::get('school_overview', '');
        } catch (\Exception $e) {
            \Log::error('principalMessage Setting::get error: ' . $e->getMessage());
            $overview = '';
        }

        return view('public.info.overview', compact('overview'));
    }

    /**
     * Display the principal message page.
     */
    public function principalMessage()
    {
        try {
            $principalName    = Setting::get('principal_name', 'Kepala Sekolah');
            $principalPhoto   = Setting::get('principal_photo', '');
            $principalMessage = Setting::get('principal_message', '');
        } catch (\Exception $e) {
            \Log::error('principalMessage Setting::get error: ' . $e->getMessage());
            $principalName    = 'Kepala Sekolah';
            $principalPhoto   = '';
            $principalMessage = '';
        }

        // Ukuran asli foto dipakai sebagai atribut width/height supaya ruang
        // gambar sudah "dipesan" browser dan tata letak tidak bergeser.
        $principalPhotoSize = $this->imageDimensions($principalPhoto);

        // Pratinjau resolusi sangat rendah (inline base64) agar foto langsung
        // terlihat begitu halaman tampil, tanpa menunggu file aslinya selesai diunduh.
        $principalPhotoPreview = $this->imagePreview($principalPhoto);

        return view('public.info.principal-message', compact(
            'principalName',
            'principalPhoto',
            'principalMessage',
            'principalPhotoSize',
            'principalPhotoPreview'
        ));
    }

    /**
     * Ukuran asli gambar pada disk publik.
     *
     * @return array{width: int, height: int}|null
     */
    private function imageDimensions(?string $relativePath): ?array
    {
        $absolutePath = $this->publicImagePath($relativePath);

        if (! $absolutePath) {
            return null;
        }

        $size = @getimagesize($absolutePath);

        if (! $size || empty($size[0]) || empty($size[1])) {
            return null;
        }

        return ['width' => (int) $size[0], 'height' => (int) $size[1]];
    }

    /**
     * Buat pratinjau gambar beresolusi sangat kecil dalam bentuk data URI.
     * Ditempel langsung di HTML sehingga tampil seketika sebagai latar,
     * lalu tertutup foto asli setelah selesai diunduh.
     */
    private function imagePreview(?string $relativePath, int $targetWidth = 28): ?string
    {
        $absolutePath = $this->publicImagePath($relativePath);

        if (! $absolutePath || ! function_exists('imagecreatefromstring')) {
            return null;
        }

        $cacheKey = 'image_preview:' . md5($absolutePath . '|' . @filemtime($absolutePath));

        return Cache::remember($cacheKey, now()->addDays(30), function () use ($absolutePath, $targetWidth) {
            try {
                $source = @imagecreatefromstring((string) file_get_contents($absolutePath));

                if (! $source) {
                    return null;
                }

                $width = imagesx($source);
                $height = imagesy($source);
                $previewHeight = max(1, (int) round($height * ($targetWidth / max(1, $width))));

                $preview = imagecreatetruecolor($targetWidth, $previewHeight);
                imagecopyresampled($preview, $source, 0, 0, 0, 0, $targetWidth, $previewHeight, $width, $height);

                ob_start();
                imagejpeg($preview, null, 60);
                $binary = (string) ob_get_clean();

                imagedestroy($source);
                imagedestroy($preview);

                return $binary === '' ? null : 'data:image/jpeg;base64,' . base64_encode($binary);
            } catch (\Throwable $e) {
                \Log::warning('Gagal membuat pratinjau gambar: ' . $e->getMessage());

                return null;
            }
        });
    }

    /**
     * Ubah path relatif storage menjadi path absolut bila filenya benar-benar ada.
     */
    private function publicImagePath(?string $relativePath): ?string
    {
        $relativePath = trim((string) $relativePath);

        if ($relativePath === '') {
            return null;
        }

        $absolutePath = storage_path('app/public/' . ltrim($relativePath, '/'));

        return is_file($absolutePath) ? $absolutePath : null;
    }
}
