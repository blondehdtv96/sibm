<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
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
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // In a real application, you would send an email here
        // For now, we'll just return success
        
        return back()->with('success', 'Thank you for your message. We will get back to you soon!');
    }

    /**
     * Display the school overview page.
     */
    public function overview()
    {
        $overview = \App\Models\Setting::get('school_overview', '');
        
        return view('public.info.overview', compact('overview'));
    }

    /**
     * Display the principal message page.
     */
    public function principalMessage()
    {
        $principalName = \App\Models\Setting::get('principal_name', 'Kepala Sekolah');
        $principalPhoto = \App\Models\Setting::get('principal_photo', '');
        $principalMessage = \App\Models\Setting::get('principal_message', '');
        
        return view('public.info.principal-message', compact(
            'principalName',
            'principalPhoto',
            'principalMessage'
        ));
    }
}
