<?php

namespace App\View\Composers;

use App\Models\Menu;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class MenuComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        try {
            $menus = Menu::active()
                ->parents()
                ->with(['children' => function ($query) {
                    $query->active()->orderBy('order');
                }])
                ->orderBy('order')
                ->get();

            $view->with('navigationMenus', $menus);
        } catch (\Exception $e) {
            // Log error but don't break the page
            Log::error('MenuComposer error: ' . $e->getMessage());
            $view->with('navigationMenus', collect([]));
        }
    }
}