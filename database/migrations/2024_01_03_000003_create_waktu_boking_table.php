<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('waktu_boking', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_waktu_layanan')
                  ->constrained('waktu_layanan')
                  ->onDelete('cascade');
            $table->foreignId('id_ruangan')
                  ->constrained('ruangan')
                  ->onDelete('cascade');
            $table->string('kode_waktu_boking'); // contoh: "08:00", "09:00", dll
            $table->boolean('active')->default(true);
            $table->timestamps();

            // Satu slot unik: waktu_layanan + ruangan + jam
            $table->unique(['id_waktu_layanan', 'id_ruangan', 'kode_waktu_boking'], 'unique_slot');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('waktu_boking');
    }
};
