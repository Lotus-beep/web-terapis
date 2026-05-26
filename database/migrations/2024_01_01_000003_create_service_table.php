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
            $table->date('date_service');
            $table->string('status_payment')->default('active');
            $table->time('time_service');
            $table->foreignId('id_terapis')->constrained('terapis')->onDelete('cascade');
            $table->decimal('price', 10, 2);
            $table->foreignId('id_location')->constrained('location')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service');
    }
};
