<?php

namespace App\View\Composers;

use App\Models\Setting;
use Illuminate\View\View;

class SettingsComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $view->with([
            'siteLogo' => Setting::get('site_logo'),
            'siteName' => Setting::get('site_name', config('app.name')),
            'siteTagline' => Setting::get('site_tagline', ''),
            
            'contactAddress' => Setting::get('contact_address', ''),
            'contactPhone' => Setting::get('contact_phone', ''),
            'contactEmail' => Setting::get('contact_email', ''),
            'contactWhatsapp' => Setting::get('contact_whatsapp', ''),
            
            'socialFacebook' => Setting::get('social_facebook', ''),
            'socialInstagram' => Setting::get('social_instagram', ''),
            'socialTwitter' => Setting::get('social_twitter', ''),
            'socialYoutube' => Setting::get('social_youtube', ''),
            'socialTiktok' => Setting::get('social_tiktok', ''),
            'socialLinkedin' => Setting::get('social_linkedin', ''),
        ]);
    }
}
