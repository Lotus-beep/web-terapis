<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_sesi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sesi')->nullable(); // e.g. 'Sesi 1'
            $table->string('jam_mulai', 5); // e.g. '08:00'
            $table->string('jam_selesai', 5); // e.g. '09:00'
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->unique(['jam_mulai', 'jam_selesai']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_sesi');
    }
};
