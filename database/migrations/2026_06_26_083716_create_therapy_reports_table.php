<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('therapy_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('booking')->onDelete('cascade');
            $table->text('keluhan_sebelum')->nullable();
            $table->json('tindakan_terapi')->nullable();
            $table->string('tekanan_darah')->nullable();
            $table->string('denyut_nadi')->nullable();
            $table->string('suhu_tubuh')->nullable();
            $table->string('kondisi_umum')->nullable();
            $table->string('area_keluhan')->nullable();
            $table->json('hasil_setelah_terapi')->nullable();
            $table->text('catatan_terapis')->nullable();
            $table->text('saran_terapis')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('therapy_reports');
    }
};
