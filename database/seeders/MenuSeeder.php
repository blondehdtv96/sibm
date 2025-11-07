<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run()
    {
        // Clear existing menus
        Menu::truncate();

        // Beranda
        Menu::create([
            'title' => 'Beranda',
            'route_name' => 'home',
            'order' => 1,
            'target' => '_self',
            'status' => 'active',
        ]);

        // Tentang - Parent Menu
        $tentang = Menu::create([
            'title' => 'Tentang',
            'route_name' => 'info.about',
            'order' => 2,
            'target' => '_self',
            'status' => 'active',
        ]);

        // Tentang - Submenus
        Menu::create([
            'title' => 'Selayang Pandang',
            'route_name' => 'info.overview',
            'parent_id' => $tentang->id,
            'order' => 1,
            'target' => '_self',
            'status' => 'active',
        ]);

        Menu::create([
            'title' => 'Sambutan Kepala Sekolah',
            'route_name' => 'info.principal-message',
            'parent_id' => $tentang->id,
            'order' => 2,
            'target' => '_self',
            'status' => 'active',
        ]);

        // Program Keahlian
        Menu::create([
            'title' => 'Program Keahlian',
            'route_name' => 'competencies.index',
            'order' => 3,
            'target' => '_self',
            'status' => 'active',
        ]);

        // Berita & Acara
        Menu::create([
            'title' => 'Berita & Acara',
            'route_name' => 'news.index',
            'order' => 4,
            'target' => '_self',
            'status' => 'active',
        ]);

        // Galeri
        Menu::create([
            'title' => 'Galeri',
            'route_name' => 'gallery.index',
            'order' => 5,
            'target' => '_self',
            'status' => 'active',
        ]);

        // PPDB
        Menu::create([
            'title' => 'PPDB',
            'route_name' => 'ppdb.register',
            'order' => 6,
            'target' => '_self',
            'status' => 'active',
        ]);

        // Kontak
        Menu::create([
            'title' => 'Kontak',
            'route_name' => 'info.contact',
            'order' => 7,
            'target' => '_self',
            'status' => 'active',
        ]);
    }
}
