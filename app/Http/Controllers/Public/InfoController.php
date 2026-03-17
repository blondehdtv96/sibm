<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Http\Request;

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

        return view('public.info.principal-message', compact(
            'principalName',
            'principalPhoto',
            'principalMessage'
        ));
    }
}
