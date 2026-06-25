<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_category_id')
                  ->constrained('service_categories')
                  ->onDelete('cascade');
            $table->string('path');          // Path di storage/app/public
            $table->integer('sort_order')->default(0);
            $table->boolean('is_primary')->default(false); // Gambar utama
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_images');
    }
};
