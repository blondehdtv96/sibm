<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $aboutMenu = DB::table('menus')
            ->whereNull('parent_id')
            ->whereIn('title', ['Tentang', 'Tentang Kami'])
            ->orderBy('id')
            ->first();

        if (!$aboutMenu) {
            $aboutMenuId = DB::table('menus')->insertGetId([
                'title' => 'Tentang',
                'url' => '#',
                'route_name' => null,
                'parent_id' => null,
                'order' => 20,
                'icon' => null,
                'target' => '_self',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $aboutMenu = (object) ['id' => $aboutMenuId];
        }

        $staffMenu = DB::table('menus')
            ->where('route_name', 'public.staff-profiles.index')
            ->first();

        $values = [
            'title' => 'Profil Guru & Tenaga Kependidikan',
            'url' => '/profil-guru-karyawan',
            'route_name' => 'public.staff-profiles.index',
            'parent_id' => $aboutMenu->id,
            'order' => 4,
            'icon' => null,
            'target' => '_self',
            'status' => 'active',
            'updated_at' => now(),
        ];

        if ($staffMenu) {
            DB::table('menus')->where('id', $staffMenu->id)->update($values);
        } else {
            DB::table('menus')->insert($values + ['created_at' => now()]);
        }
    }

    public function down(): void
    {
        DB::table('menus')->where('route_name', 'public.staff-profiles.index')->delete();
    }
};
