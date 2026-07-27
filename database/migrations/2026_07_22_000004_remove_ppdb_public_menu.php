<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('menus')
            ->where('route_name', 'ppdb.register')
            ->orWhereRaw('LOWER(title) = ?', ['ppdb'])
            ->delete();
    }

    public function down(): void
    {
        // The public PPDB route remains available, but its navigation item is intentionally removed.
    }
};
