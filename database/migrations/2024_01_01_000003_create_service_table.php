<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service', function (Blueprint $table) {
            $table->id();
            $table->string('name_service');
            $table->foreignId('id_category')
                  ->nullable()
                  ->constrained('service_categories')
                  ->onDelete('set null');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->decimal('price', 10, 2);
            $table->foreignId('id_terapis')->constrained('terapis')->onDelete('cascade');
            $table->foreignId('id_location')->constrained('location')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service');
    }
};
