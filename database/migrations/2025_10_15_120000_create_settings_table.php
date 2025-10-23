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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('text'); // text, image, file, json
            $table->string('group')->default('general'); // general, appearance, system
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Insert default settings
        DB::table('settings')->insert([
            [
                'key' => 'site_logo',
                'value' => null,
                'type' => 'image',
                'group' => 'appearance',
                'description' => 'Logo sekolah yang ditampilkan di header',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'site_logo_dark',
                'value' => null,
                'type' => 'image',
                'group' => 'appearance',
                'description' => 'Logo sekolah untuk dark mode',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'site_favicon',
                'value' => null,
                'type' => 'image',
                'group' => 'appearance',
                'description' => 'Favicon website',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'site_name',
                'value' => 'SMK Bina Mandiri Bekasi',
                'type' => 'text',
                'group' => 'general',
                'description' => 'Nama sekolah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'site_tagline',
                'value' => 'Unggul dalam Prestasi, Berkarakter dalam Kehidupan',
                'type' => 'text',
                'group' => 'general',
                'description' => 'Tagline sekolah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
