<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing menus
        Menu::truncate();

        // Beranda
        Menu::create([
            'title' => 'Beranda',
            'route_name' => 'home',
            'parent_id' => null,
            'order' => 10,
            'target' => '_self',
            'status' => 'active',
        ]);

        // Tentang Kami (Parent)
        $aboutMenu = Menu::create([
            'title' => 'Tentang Kami',
            'route_name' => null,
            'url' => '#',
            'parent_id' => null,
            'order' => 20,
            'target' => '_self',
            'status' => 'active',
        ]);

        // Tentang Kami - Submenu
        Menu::create([
            'title' => 'Profil Sekolah',
            'route_name' => 'info.about',
            'parent_id' => $aboutMenu->id,
            'order' => 1,
            'target' => '_self',
            'status' => 'active',
        ]);

        Menu::create([
            'title' => 'Selayang Pandang',
            'route_name' => 'info.overview',
            'parent_id' => $aboutMenu->id,
            'order' => 2,
            'target' => '_self',
            'status' => 'active',
        ]);

        Menu::create([
            'title' => 'Sambutan Kepala Sekolah',
            'route_name' => 'info.principal-message',
            'parent_id' => $aboutMenu->id,
            'order' => 3,
            'target' => '_self',
            'status' => 'active',
        ]);

        // Program Keahlian
        Menu::create([
            'title' => 'Program Keahlian',
            'route_name' => 'public.competencies.index',
            'parent_id' => null,
            'order' => 30,
            'target' => '_self',
            'status' => 'active',
        ]);

        // Berita
        Menu::create([
            'title' => 'Berita',
            'route_name' => 'public.news.index',
            'parent_id' => null,
            'order' => 40,
            'target' => '_self',
            'status' => 'active',
        ]);

        // Galeri
        Menu::create([
            'title' => 'Galeri',
            'route_name' => 'public.gallery.index',
            'parent_id' => null,
            'order' => 50,
            'target' => '_self',
            'status' => 'active',
        ]);

        // PPDB
        Menu::create([
            'title' => 'PPDB',
            'route_name' => 'ppdb.register',
            'parent_id' => null,
            'order' => 60,
            'target' => '_self',
            'status' => 'active',
        ]);

        // Kontak
        Menu::create([
            'title' => 'Kontak',
            'route_name' => 'info.contact',
            'parent_id' => null,
            'order' => 70,
            'target' => '_self',
            'status' => 'active',
        ]);
    }
}
