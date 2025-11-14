<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('competencies', function (Blueprint $table) {
            $table->string('head_of_program_name')->nullable()->after('description');
            $table->string('head_of_program_photo')->nullable()->after('head_of_program_name');
            $table->text('head_of_program_message')->nullable()->after('head_of_program_photo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('competencies', function (Blueprint $table) {
            $table->dropColumn(['head_of_program_name', 'head_of_program_photo', 'head_of_program_message']);
        });
    }
};
