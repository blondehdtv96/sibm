<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PpdbSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PpdbSettingController extends Controller
{
    public function index()
    {
        $settings = PpdbSetting::latest()->paginate(10);
        return view('admin.ppdb-settings.index', compact('settings'));
    }

    public function create()
    {
        return view('admin.ppdb-settings.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'registration_start' => 'required|date',
            'registration_end' => 'required|date|after:registration_start',
            'requirements' => 'nullable|array',
            'requirements.*' => 'string',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Deactivate all other settings if this one is active
        if ($request->status === 'active') {
            PpdbSetting::where('status', 'active')->update(['status' => 'inactive']);
        }

        $requirements = $request->requirements ? array_filter($request->requirements) : [];

        PpdbSetting::create([
            'registration_start' => $request->registration_start,
            'registration_end' => $request->registration_end,
            'requirements' => json_encode($requirements),
            'status' => $request->status,
        ]);

        return redirect()->route('admin.ppdb-settings.index')
            ->with('success', 'PPDB settings created successfully.');
    }

    public function edit(PpdbSetting $ppdbSetting)
    {
        return view('admin.ppdb-settings.edit', compact('ppdbSetting'));
    }

    public function update(Request $request, PpdbSetting $ppdbSetting)
    {
        $validator = Validator::make($request->all(), [
            'registration_start' => 'required|date',
            'registration_end' => 'required|date|after:registration_start',
            'requirements' => 'nullable|array',
            'requirements.*' => 'string',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Deactivate all other settings if this one is active
        if ($request->status === 'active') {
            PpdbSetting::where('status', 'active')
                ->where('id', '!=', $ppdbSetting->id)
                ->update(['status' => 'inactive']);
        }

        $requirements = $request->requirements ? array_filter($request->requirements) : [];

        $ppdbSetting->update([
            'registration_start' => $request->registration_start,
            'registration_end' => $request->registration_end,
            'requirements' => json_encode($requirements),
            'status' => $request->status,
        ]);

        return redirect()->route('admin.ppdb-settings.index')
            ->with('success', 'PPDB settings updated successfully.');
    }

    public function destroy(PpdbSetting $ppdbSetting)
    {
        $ppdbSetting->delete();

        return redirect()->route('admin.ppdb-settings.index')
            ->with('success', 'PPDB settings deleted successfully.');
    }

    public function toggleStatus(PpdbSetting $ppdbSetting)
    {
        $newStatus = $ppdbSetting->status === 'active' ? 'inactive' : 'active';

        // If activating, deactivate all others
        if ($newStatus === 'active') {
            PpdbSetting::where('status', 'active')
                ->where('id', '!=', $ppdbSetting->id)
                ->update(['status' => 'inactive']);
        }

        $ppdbSetting->update(['status' => $newStatus]);

        return redirect()->back()
            ->with('success', 'PPDB registration status updated successfully.');
    }
}
