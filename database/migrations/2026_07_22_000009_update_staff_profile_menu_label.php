<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('menus')->where('route_name', 'public.staff-profiles.index')->update([
            'title' => 'Profil Guru & Tenaga Kependidikan',
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('menus')->where('route_name', 'public.staff-profiles.index')->update([
            'title' => 'Profil Guru dan Karyawan',
            'updated_at' => now(),
        ]);
    }
};
