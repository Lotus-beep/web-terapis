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
            $table->string('name');           // Nama layanan, contoh: "Bekam Umum"
            $table->string('slug')->unique(); // Slug unik
            $table->string('category')->default('bekam'); // Kategori besar: bekam / non-bekam
            $table->string('header_content')->nullable(); // Judul display layanan
            $table->text('description')->nullable();
            $table->string('icon')->default('bi-heart-pulse-fill');
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->decimal('price', 10, 2)->default(0.00);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_categories');
    }
};
