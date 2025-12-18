<?php

namespace App\Console\Commands;

use App\Models\Menu;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class FixMenuRoutes extends Command
{
    protected $signature = 'menu:fix-routes';
    protected $description = 'Fix invalid route names in menu table';

    // Map of old/invalid route names to correct ones
    protected $routeMap = [
        // Competencies variations
        'competencies.index' => 'public.competencies.index',
        'competencies.show' => 'public.competencies.show',
        'competency.index' => 'public.competencies.index',
        'program-keahlian' => 'public.competencies.index',
        'jurusan' => 'public.competencies.index',
        // News variations
        'news.index' => 'public.news.index',
        'news.show' => 'public.news.show',
        'berita' => 'public.news.index',
        // Gallery variations
        'gallery.index' => 'public.gallery.index',
        'gallery.show' => 'public.gallery.show',
        'galeri' => 'public.gallery.index',
        // Pages
        'pages.show' => 'public.pages.show',
    ];

    public function handle(): int
    {
        $this->info('Checking menu routes...');
        
        $menus = Menu::whereNotNull('route_name')->get();
        $fixed = 0;
        $invalid = 0;

        foreach ($menus as $menu) {
            $routeName = $menu->route_name;
            
            // Check if route exists
            if (!Route::has($routeName)) {
                $this->warn("Invalid route: {$routeName} (Menu: {$menu->title})");
                
                // Try to fix using map
                if (isset($this->routeMap[$routeName])) {
                    $newRoute = $this->routeMap[$routeName];
                    if (Route::has($newRoute)) {
                        $menu->route_name = $newRoute;
                        $menu->save();
                        $this->info("  -> Fixed to: {$newRoute}");
                        $fixed++;
                    } else {
                        $this->error("  -> Mapped route also invalid: {$newRoute}");
                        $invalid++;
                    }
                } else {
                    // Clear invalid route, use URL fallback
                    $this->error("  -> No mapping found, clearing route_name");
                    $menu->route_name = null;
                    $menu->url = '#';
                    $menu->save();
                    $invalid++;
                }
            } else {
                $this->line("Valid route: {$routeName} (Menu: {$menu->title})");
            }
        }

        $this->newLine();
        $this->info("Summary:");
        $this->info("  - Fixed: {$fixed}");
        $this->info("  - Invalid (cleared): {$invalid}");
        
        return Command::SUCCESS;
    }
}
