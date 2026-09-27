<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS in production
        if (app()->environment('production')) {
            \URL::forceScheme('https');
        }
        
        // Share settings data with all public views
        view()->composer('layouts.public-tailwind', \App\View\Composers\SettingsComposer::class);
        
        // Share menu data with all public views
        view()->composer('layouts.public-tailwind', \App\View\Composers\MenuComposer::class);

        $this->refreshChatbotKnowledgeOnContentChange();
    }

    /**
     * Segarkan pengetahuan chatbot AI setiap kali konten website berubah,
     * supaya jawaban chatbot selalu mengikuti isi website terbaru.
     */
    private function refreshChatbotKnowledgeOnContentChange(): void
    {
        $models = [
            \App\Models\Announcement::class,
            \App\Models\Competency::class,
            \App\Models\GalleryAlbum::class,
            \App\Models\IndustryPartner::class,
            \App\Models\Menu::class,
            \App\Models\News::class,
            \App\Models\Page::class,
            \App\Models\PpdbSetting::class,
            \App\Models\Setting::class,
            \App\Models\StaffProfile::class,
            \App\Models\Statistic::class,
        ];

        $forget = fn () => app(\App\Services\SchoolKnowledgeService::class)->forget();

        foreach ($models as $model) {
            $model::saved($forget);
            $model::deleted($forget);
        }
    }
}
