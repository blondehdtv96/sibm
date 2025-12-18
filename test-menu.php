<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Menu;

echo "=== TESTING MENU SYSTEM ===\n\n";

// Test 1: Count total menus
$totalMenus = Menu::count();
echo "Total menus in database: {$totalMenus}\n\n";

// Test 2: Active menus
$activeMenus = Menu::active()->count();
echo "Active menus: {$activeMenus}\n\n";

// Test 3: Parent menus
$parentMenus = Menu::active()->parents()->get();
echo "Parent menus:\n";
foreach ($parentMenus as $menu) {
    echo "- {$menu->title} (Order: {$menu->order})\n";
    
    // Show children
    if ($menu->children->count() > 0) {
        foreach ($menu->children as $child) {
            echo "  └─ {$child->title}\n";
        }
    }
}

echo "\n=== MENU COMPOSER TEST ===\n";

// Test MenuComposer
$composer = new \App\View\Composers\MenuComposer();
$view = new \Illuminate\View\View(
    app('view'),
    app('view.engine.resolver')->resolve('blade'),
    'test',
    '',
    []
);

$composer->compose($view);
$navigationMenus = $view->getData()['navigationMenus'] ?? null;

if ($navigationMenus) {
    echo "MenuComposer loaded " . $navigationMenus->count() . " menus\n";
    foreach ($navigationMenus as $menu) {
        echo "- {$menu->title} -> {$menu->full_url}\n";
    }
} else {
    echo "MenuComposer failed to load menus\n";
}

echo "\n=== TEST COMPLETED ===\n";