<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Recreate ppdb_settings when its original migration is marked as ran
     * but the physical table is missing from the active database.
     */
    public function up(): void
    {
        if (Schema::hasTable('ppdb_settings')) {
            return;
        }

        Schema::create('ppdb_settings', function (Blueprint $table) {
            $table->id();
            $table->date('registration_start');
            $table->date('registration_end');
            $table->json('requirements')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->timestamps();

            $table->index('status');
            $table->index(['registration_start', 'registration_end']);
        });
    }

    /**
     * Do not remove the original PPDB settings table when rolling back this repair.
     */
    public function down(): void
    {
        // Intentionally left blank.
    }
};
