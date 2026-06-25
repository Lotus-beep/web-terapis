<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('booking', function (Blueprint $table) {
            if (!Schema::hasColumn('booking', 'id_bed')) {
                $table->foreignId('id_bed')
                      ->nullable()
                      ->after('id_ruangan')
                      ->constrained('beds')
                      ->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('booking', function (Blueprint $table) {
            if (Schema::hasColumn('booking', 'id_bed')) {
                try {
                    $table->dropForeign(['id_bed']);
                } catch (\Exception $e) {}
                $table->dropColumn('id_bed');
            }
        });
    }
};
