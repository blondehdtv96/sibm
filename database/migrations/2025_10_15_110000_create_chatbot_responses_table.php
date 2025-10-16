<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tabel untuk menyimpan balasan chatbot yang bisa dikelola admin
     */
    public function up(): void
    {
        Schema::create('chatbot_responses', function (Blueprint $table) {
            $table->id();
            $table->string('trigger_name')->unique(); // Nama trigger (contoh: greeting, jurusan, ppdb)
            $table->string('title'); // Judul untuk admin
            $table->text('keywords'); // Keywords yang memicu response (JSON array)
            $table->text('response'); // Balasan bot
            $table->boolean('is_active')->default(true); // Status aktif/nonaktif
            $table->integer('priority')->default(0); // Prioritas (semakin tinggi semakin prioritas)
            $table->timestamps();
            
            // Index untuk performa
            $table->index('is_active');
            $table->index('priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chatbot_responses');
    }
};
