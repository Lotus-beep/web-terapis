<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('booking', function (Blueprint $table) {
            if (!Schema::hasColumn('booking', 'id_location')) {
                $table->unsignedBigInteger('id_location')->nullable()->after('id_terapis');
                $table->foreign('id_location')->references('id')->on('location')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('booking', function (Blueprint $table) {
            if (Schema::hasColumn('booking', 'id_location')) {
                try { $table->dropForeign(['id_location']); } catch (\Exception $e) {}
                $table->dropColumn('id_location');
            }
        });
    }
};
