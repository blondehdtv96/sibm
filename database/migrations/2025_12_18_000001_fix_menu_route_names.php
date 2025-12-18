<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fix invalid route names in menus table
        $routeMap = [
            // Competencies
            'competencies.index' => 'public.competencies.index',
            'competencies.show' => 'public.competencies.show',
            'competency.index' => 'public.competencies.index',
            'program-keahlian' => 'public.competencies.index',
            'jurusan' => 'public.competencies.index',
            // News
            'news.index' => 'public.news.index',
            'news.show' => 'public.news.show',
            'berita' => 'public.news.index',
            // Gallery
            'gallery.index' => 'public.gallery.index',
            'gallery.show' => 'public.gallery.show',
            'galeri' => 'public.gallery.index',
            // Pages
            'pages.show' => 'public.pages.show',
        ];

        foreach ($routeMap as $oldRoute => $newRoute) {
            DB::table('menus')
                ->where('route_name', $oldRoute)
                ->update(['route_name' => $newRoute]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse the route name changes
        $routeMap = [
            'public.competencies.index' => 'competencies.index',
            'public.competencies.show' => 'competencies.show',
            'public.news.index' => 'news.index',
            'public.news.show' => 'news.show',
            'public.gallery.index' => 'gallery.index',
            'public.gallery.show' => 'gallery.show',
            'public.pages.show' => 'pages.show',
        ];

        foreach ($routeMap as $oldRoute => $newRoute) {
            DB::table('menus')
                ->where('route_name', $oldRoute)
                ->update(['route_name' => $newRoute]);
        }
    }
};
