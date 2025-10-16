<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Membuat tabel untuk menyimpan riwayat percakapan chatbot
     */
    public function up(): void
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->nullable(); // ID sesi untuk tracking percakapan
            $table->text('user_message'); // Pesan dari user
            $table->text('bot_reply'); // Balasan dari bot
            $table->string('ip_address')->nullable(); // IP address user
            $table->string('user_agent')->nullable(); // Browser user
            $table->timestamps();
            
            // Index untuk performa query
            $table->index('session_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
