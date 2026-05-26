<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_customer')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_terapis')->constrained('terapis')->onDelete('cascade');
            $table->date('date_booking');
            $table->enum('status_payment', ['unpaid', 'waiting_confirmation', 'paid', 'rejected'])->default('unpaid');
            $table->foreignId('id_service')->constrained('service')->onDelete('cascade');
            $table->enum('status_service', ['pending', 'confirmed', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->time('time_booking');
            $table->string('payment_proof')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};
