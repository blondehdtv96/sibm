<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PpdbRegistration;
use App\Models\PpdbSetting;
use App\Models\User;
use App\Notifications\NewPpdbRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;

class PpdbController extends Controller
{
    public function index()
    {
        $activeSetting = PpdbSetting::where('status', 'active')->first();
        
        if (!$activeSetting) {
            return view('public.ppdb.closed');
        }

        $now = Carbon::now();
        $registrationStart = Carbon::parse($activeSetting->registration_start);
        $registrationEnd = Carbon::parse($activeSetting->registration_end);

        if ($now->lt($registrationStart)) {
            return view('public.ppdb.not-started', compact('activeSetting'));
        }

        if ($now->gt($registrationEnd)) {
            return view('public.ppdb.closed');
        }

        $requirements = is_string($activeSetting->requirements) 
            ? json_decode($activeSetting->requirements, true) 
            : $activeSetting->requirements;

        return view('public.ppdb.register', compact('activeSetting', 'requirements'));
    }

    public function store(Request $request)
    {
        $activeSetting = PpdbSetting::where('status', 'active')->first();
        
        if (!$activeSetting) {
            return redirect()->back()->with('error', 'Registration is currently closed.');
        }

        $now = Carbon::now();
        $registrationStart = Carbon::parse($activeSetting->registration_start);
        $registrationEnd = Carbon::parse($activeSetting->registration_end);

        if ($now->lt($registrationStart) || $now->gt($registrationEnd)) {
            return redirect()->back()->with('error', 'Registration is not available at this time.');
        }

        $validator = Validator::make($request->all(), [
            'student_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'birth_date' => 'required|date|before:today',
            'address' => 'required|string',
            'parent_name' => 'required|string|max:255',
            'parent_phone' => 'required|string|max:20',
            'documents.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Generate unique registration number
        $registrationNumber = $this->generateRegistrationNumber();

        // Handle document uploads
        $documents = [];
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $key => $file) {
                $path = $file->store('ppdb-documents', 'public');
                $documents[$key] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                ];
            }
        }

        $registration = PpdbRegistration::create([
            'registration_number' => $registrationNumber,
            'student_name' => $request->student_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'birth_date' => $request->birth_date,
            'address' => $request->address,
            'parent_name' => $request->parent_name,
            'parent_phone' => $request->parent_phone,
            'documents' => json_encode($documents),
            'status' => 'pending',
        ]);

        // Send notification to all admin users
        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new NewPpdbRegistration($registration));

        return redirect()->route('ppdb.success', $registration->registration_number)
            ->with('success', 'Registration submitted successfully!');
    }

    public function success($registrationNumber)
    {
        $registration = PpdbRegistration::where('registration_number', $registrationNumber)->firstOrFail();
        return view('public.ppdb.success', compact('registration'));
    }

    public function checkStatus()
    {
        return view('public.ppdb.check-status');
    }

    public function showStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'registration_number' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $registration = PpdbRegistration::where('registration_number', $request->registration_number)->first();

        if (!$registration) {
            return redirect()->back()
                ->with('error', 'Registration number not found.')
                ->withInput();
        }

        return view('public.ppdb.status', compact('registration'));
    }

    private function generateRegistrationNumber()
    {
        $year = date('Y');
        $lastRegistration = PpdbRegistration::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        if ($lastRegistration) {
            $lastNumber = intval(substr($lastRegistration->registration_number, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return 'PPDB' . $year . $newNumber;
    }
}
