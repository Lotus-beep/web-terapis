<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');           // Nama kategori, contoh: "Bekam Umum"
            $table->string('slug')->unique(); // Slug unik, contoh: "bekam-umum"
            $table->text('description')->nullable();
            $table->string('icon')->default('bi-heart-pulse-fill'); // Bootstrap icon class
            $table->string('image')->nullable();  // Foto representasi kategori
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0); // Urutan tampil
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_categories');
    }
};
