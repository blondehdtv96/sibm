<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Repair imported migrations tables that lost their primary key or
     * AUTO_INCREMENT definition.
     */
    public function up(): void
    {
        if (DB::getDriverName() !== 'mysql' || !Schema::hasTable('migrations')) {
            return;
        }

        $primaryKey = DB::selectOne("SHOW KEYS FROM `migrations` WHERE Key_name = 'PRIMARY'");
        if (!$primaryKey) {
            DB::statement("ALTER TABLE `migrations` ADD PRIMARY KEY (`id`)");
        }

        $idColumn = DB::selectOne("SHOW COLUMNS FROM `migrations` WHERE Field = 'id'");
        if ($idColumn && !str_contains(strtolower((string) $idColumn->Extra), 'auto_increment')) {
            $type = str_contains(strtolower((string) $idColumn->Type), 'bigint')
                ? 'BIGINT UNSIGNED'
                : 'INT UNSIGNED';

            DB::statement("ALTER TABLE `migrations` MODIFY `id` {$type} NOT NULL AUTO_INCREMENT");
        }
    }

    public function down(): void
    {
        // Do not remove the repository key or auto-increment behavior.
    }
};
