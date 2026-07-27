<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StaffProfileResource;
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
            ->ordered()->paginate(min((int) $request->input('per_page', 12), 50));

        return StaffProfileResource::collection($profiles);
    }

    public function show(StaffProfile $staffProfile)
    {
        abort_unless($staffProfile->status === 'active', 404);
        return new StaffProfileResource($staffProfile->load('activeImages'));
    }
}
