<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('booking', function (Blueprint $table) {
            if (!Schema::hasColumn('booking', 'id_waktu_boking')) {
                $table->foreignId('id_waktu_boking')
                      ->nullable()
                      ->after('id_service')
                      ->constrained('waktu_boking')
                      ->onDelete('set null');
            }
            if (!Schema::hasColumn('booking', 'id_ruangan')) {
                $table->foreignId('id_ruangan')
                      ->nullable()
                      ->after('id_waktu_boking')
                      ->constrained('ruangan')
                      ->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('booking', function (Blueprint $table) {
            if (Schema::hasColumn('booking', 'id_waktu_boking')) {
                try { $table->dropForeign(['id_waktu_boking']); } catch (\Exception $e) {}
                $table->dropColumn('id_waktu_boking');
            }
            if (Schema::hasColumn('booking', 'id_ruangan')) {
                try { $table->dropForeign(['id_ruangan']); } catch (\Exception $e) {}
                $table->dropColumn('id_ruangan');
            }
        });
    }
};
