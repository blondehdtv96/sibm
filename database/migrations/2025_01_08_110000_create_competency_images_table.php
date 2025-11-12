<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('competency_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('competency_id')->constrained()->onDelete('cascade');
            $table->string('image_path');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            
            $table->index(['competency_id', 'order']);
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('competency_images');
    }
};
