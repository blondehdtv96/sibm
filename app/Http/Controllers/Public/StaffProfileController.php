<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\StaffProfile;
use Illuminate\Http\Request;

class StaffProfileController extends Controller
{
    public function index(Request $request)
    {
        $profiles = StaffProfile::active()->with('activeImages')
            ->search($request->input('search'))
            ->when($request->filled('category'), fn ($q) => $q->where('category', $request->category))
            ->when($request->filled('jurusan'), fn ($q) => $q->where('jurusan', 'like', '%' . $request->jurusan . '%'))
            ->when($request->filled('employment_status'), fn ($q) => $q->where('employment_status', $request->employment_status))
            ->ordered()->paginate(12)->withQueryString();

        $active = StaffProfile::active();
        $stats = [
            'total' => (clone $active)->count(),
            'staff' => (clone $active)->where('category', '!=', 'Guru')->count(),
            'certified' => (clone $active)->whereNotNull('certifications')->where('certifications', '!=', '')->count(),
            'productive' => (clone $active)->where('category', 'Guru Produktif')->count(),
            'normative' => (clone $active)->where('category', 'Guru Normatif')->count(),
            'adaptive' => (clone $active)->where('category', 'Guru Adaptif')->count(),
            's2' => (clone $active)->where('education', 'like', '%S2%')->count(),
            's3' => (clone $active)->where('education', 'like', '%S3%')->count(),
        ];

        return view('public.staff-profiles.index', [
            'staffProfiles' => $profiles,
            'stats' => $stats,
            'categories' => ['Guru', 'Tenaga Kependidikan', 'Kepala Sekolah', 'Wakil Kepala Sekolah', 'Kaprog', 'Guru Produktif', 'Guru Normatif', 'Guru Adaptif', 'Staff TU'],
            'employmentStatuses' => ['ASN', 'Honorer', 'Kontrak', 'Tetap', 'Kepala Sekolah', 'Waka', 'Kaprog'],
        ]);
    }

    public function show(StaffProfile $staffProfile)
    {
        abort_unless($staffProfile->status === 'active', 404);
        $staffProfile->load('activeImages');
        $related = StaffProfile::active()->ordered()->where('id', '!=', $staffProfile->id)->take(4)->get();
        return view('public.staff-profiles.show', compact('staffProfile', 'related'));
    }
}
