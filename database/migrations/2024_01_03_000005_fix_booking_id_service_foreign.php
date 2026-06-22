<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Drop FK lama ke tabel service
        try {
            Schema::table('booking', function (Blueprint $table) {
                $table->dropForeign('booking_id_service_foreign');
            });
        } catch (\Exception $e) {
            // FK mungkin sudah tidak ada
        }

        // Update FK ke service_categories
        Schema::table('booking', function (Blueprint $table) {
            $table->foreign('id_service')
                  ->references('id')
                  ->on('service_categories')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        try {
            Schema::table('booking', function (Blueprint $table) {
                $table->dropForeign(['id_service']);
            });
        } catch (\Exception $e) {}

        Schema::table('booking', function (Blueprint $table) {
            $table->foreign('id_service')
                  ->references('id')
                  ->on('service')
                  ->onDelete('cascade');
        });
    }
};
