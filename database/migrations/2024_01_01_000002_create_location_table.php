<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('location', function (Blueprint $table) {
            $table->id();
            $table->string('name_location');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('location');
    }
};
