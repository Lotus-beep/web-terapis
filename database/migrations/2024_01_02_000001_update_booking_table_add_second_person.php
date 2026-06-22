<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('booking', function (Blueprint $table) {
            // Buat id_terapis nullable
            $table->unsignedBigInteger('id_terapis')->nullable()->change();

            if (!Schema::hasColumn('booking', 'booking_for')) {
                $table->enum('booking_for', ['self', 'other'])->default('self')->after('id_service');
            }
            if (!Schema::hasColumn('booking', 'second_username')) {
                $table->string('second_username')->nullable()->after('booking_for');
            }
            if (!Schema::hasColumn('booking', 'gender_second')) {
                $table->enum('gender_second', ['laki-laki', 'perempuan'])->nullable()->after('second_username');
            }
        });
    }

    public function down(): void
    {
        Schema::table('booking', function (Blueprint $table) {
            if (Schema::hasColumn('booking', 'booking_for')) $table->dropColumn('booking_for');
            if (Schema::hasColumn('booking', 'second_username')) $table->dropColumn('second_username');
            if (Schema::hasColumn('booking', 'gender_second')) $table->dropColumn('gender_second');
        });
    }
};
