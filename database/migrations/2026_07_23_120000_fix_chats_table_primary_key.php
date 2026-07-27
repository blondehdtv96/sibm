<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Perbaikan data pre-existing: kolom `id` pada tabel `chats` tidak memiliki
     * PRIMARY KEY/AUTO_INCREMENT di beberapa instalasi (migration awal tidak
     * ter-apply dengan benar), sehingga setiap insert chat baru gagal dengan
     * error "Field 'id' doesn't have a default value". Migration ini aman
     * dijalankan berulang dan tidak menghapus data yang sudah ada.
     */
    public function up(): void
    {
        if (! Schema::hasTable('chats')) {
            return;
        }

        $hasPrimaryKey = DB::selectOne(
            "SELECT COUNT(*) as total FROM information_schema.KEY_COLUMN_USAGE
             WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'chats' AND CONSTRAINT_NAME = 'PRIMARY'"
        )?->total ?? 0;

        if ($hasPrimaryKey == 0) {
            // Backfill id kosong/duplikat sebelum menjadikannya primary key.
            DB::statement('SET @row := 0');
            DB::statement('UPDATE chats SET id = (@row := @row + 1) WHERE id IS NULL OR id = 0');

            // MySQL requires the AUTO_INCREMENT column to already be a key,
            // so the primary key must be added before enabling AUTO_INCREMENT.
            DB::statement('ALTER TABLE chats ADD PRIMARY KEY (id)');
            DB::statement('ALTER TABLE chats MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');
        }
    }

    public function down(): void
    {
        // Tidak menghapus primary key saat rollback untuk menghindari kerusakan data.
    }
};
