<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('waktu_layanan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->time('waktu_buka');
            $table->time('waktu_tutup');
            $table->unsignedTinyInteger('maximal')->default(10); // total slot per hari
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->unique('tanggal'); // 1 jadwal per tanggal
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('waktu_layanan');
    }
};
