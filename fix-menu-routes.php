<?php
/**
 * Script untuk memperbaiki route names di tabel menus
 * Jalankan dengan: php artisan tinker < fix-menu-routes.php
 * Atau: php fix-menu-routes.php (jika autoload tersedia)
 */

// Jika dijalankan langsung (bukan via tinker)
if (!function_exists('app')) {
    require __DIR__.'/vendor/autoload.php';
    $app = require_once __DIR__.'/bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
}

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

echo "=== Fixing Menu Route Names ===\n\n";

// Route mapping
$routeMap = [
    'competencies.index' => 'public.competencies.index',
    'competencies.show' => 'public.competencies.show',
    'competency.index' => 'public.competencies.index',
    'news.index' => 'public.news.index',
    'news.show' => 'public.news.show',
    'gallery.index' => 'public.gallery.index',
    'gallery.show' => 'public.gallery.show',
    'pages.show' => 'public.pages.show',
];

// Get all menus with route_name
$menus = DB::table('menus')->whereNotNull('route_name')->get();

$fixed = 0;
$valid = 0;
$invalid = 0;

foreach ($menus as $menu) {
    $routeName = $menu->route_name;
    
    // Check if route exists
    if (Route::has($routeName)) {
        echo "[OK] {$menu->title}: {$routeName}\n";
        $valid++;
        continue;
    }
    
    // Try to fix
    if (isset($routeMap[$routeName])) {
        $newRoute = $routeMap[$routeName];
        if (Route::has($newRoute)) {
            DB::table('menus')
                ->where('id', $menu->id)
                ->update(['route_name' => $newRoute]);
            echo "[FIXED] {$menu->title}: {$routeName} -> {$newRoute}\n";
            $fixed++;
            continue;
        }
    }
    
    echo "[INVALID] {$menu->title}: {$routeName} (no mapping found)\n";
    $invalid++;
}

echo "\n=== Summary ===\n";
echo "Valid: {$valid}\n";
echo "Fixed: {$fixed}\n";
echo "Invalid: {$invalid}\n";

// Clear cache
if (function_exists('artisan')) {
    echo "\nClearing caches...\n";
    \Artisan::call('cache:clear');
    \Artisan::call('view:clear');
    echo "Done!\n";
}
