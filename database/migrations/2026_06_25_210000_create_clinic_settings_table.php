<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clinic_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('label')->nullable(); // Label tampilan
            $table->timestamps();
        });

        // Seed nilai default
        $now = now();
        DB::table('clinic_settings')->insert([
            ['key' => 'clinic_name',       'value' => 'Rumah Bekam Salam Insani',        'label' => 'Nama Klinik',          'created_at' => $now, 'updated_at' => $now],
            ['key' => 'clinic_address',    'value' => 'Jl. Rawa Belong Raya No. 10, Palmerah, Jakarta Barat, DKI Jakarta 11480', 'label' => 'Alamat Lengkap', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'clinic_phone',      'value' => '+62 812-3456-7890',                'label' => 'Nomor Telepon',        'created_at' => $now, 'updated_at' => $now],
            ['key' => 'clinic_hours',      'value' => 'Senin – Sabtu: 08.00 – 17.00 WIB', 'label' => 'Jam Operasional',    'created_at' => $now, 'updated_at' => $now],
            ['key' => 'maps_embed_url',    'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.4!2d106.779!3d-6.200!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMTInMDAuMCJTIDEwNsKwNDYnNDQuNCJF!5e0!3m2!1sid!2sid!4v1609459200000!5m2!1sid!2sid', 'label' => 'Google Maps Embed URL', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'maps_link',         'value' => 'https://maps.google.com/?q=Rawa+Belong+Jakarta+Barat', 'label' => 'Link Google Maps',   'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('clinic_settings');
    }
};
