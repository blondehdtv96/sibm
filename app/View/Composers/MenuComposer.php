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
            $withoutPpdbMenu = function ($query) {
                $query->where(function ($query) {
                    $query->whereNull('route_name')
                        ->orWhere('route_name', '!=', 'ppdb.register');
                })->whereRaw('LOWER(title) != ?', ['ppdb']);
            };

            $menus = Menu::active()
                ->parents()
                ->where($withoutPpdbMenu)
                ->with(['children' => function ($query) use ($withoutPpdbMenu) {
                    $query->active()
                        ->where($withoutPpdbMenu)
                        ->orderBy('order');
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