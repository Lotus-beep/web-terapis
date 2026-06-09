<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Service;
use App\Models\ServiceCategory;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil ID kategori dari tabel (sudah diisi ServiceCategorySeeder)
        $categories = ServiceCategory::pluck('id', 'slug');

        // Ambil ID lokasi pertama yang ada
        $locationId = DB::table('location')->value('id') ?? 1;

        $services = [
            [
                'name_service' => 'Bekam Basah Standar',
                'id_category'  => $categories['bekam-umum']    ?? null,
                'description'  => 'Terapi bekam basah standar untuk membersihkan darah kotor dan meningkatkan imunitas tubuh.',
                'id_terapis'   => 1,
                'price'        => 150000,
                'id_location'  => $locationId,
                'is_active'    => true,
            ],
            [
                'name_service' => 'Fashdu Punggung',
                'id_category'  => $categories['fashdu']         ?? null,
                'description'  => 'Bekam kering area punggung untuk melancarkan sirkulasi darah dan meredakan nyeri otot.',
                'id_terapis'   => 2,
                'price'        => 100000,
                'id_location'  => $locationId,
                'is_active'    => true,
            ],
            [
                'name_service' => 'Gurah Hidung & Tenggorokan',
                'id_category'  => $categories['gurah']          ?? null,
                'description'  => 'Membersihkan saluran pernapasan dari lendir dan kotoran. Cocok untuk penderita sinusitis.',
                'id_terapis'   => 3,
                'price'        => 120000,
                'id_location'  => $locationId,
                'is_active'    => true,
            ],
            [
                'name_service' => 'Akupuntur Relaksasi',
                'id_category'  => $categories['akupuntur']      ?? null,
                'description'  => 'Terapi akupuntur untuk relaksasi, mengurangi stres, dan menyeimbangkan energi tubuh.',
                'id_terapis'   => 1,
                'price'        => 200000,
                'id_location'  => $locationId,
                'is_active'    => true,
            ],
            [
                'name_service' => 'Pijat Syaraf Kejepit Pinggang',
                'id_category'  => $categories['pijat-syaraf-kejepit'] ?? null,
                'description'  => 'Terapi khusus syaraf kejepit area pinggang dan punggung bawah. Aman dan efektif.',
                'id_terapis'   => 2,
                'price'        => 175000,
                'id_location'  => $locationId,
                'is_active'    => true,
            ],
            [
                'name_service' => 'Pijat Bayi 0-12 Bulan',
                'id_category'  => $categories['pijat-bayi-anak'] ?? null,
                'description'  => 'Pijat lembut untuk bayi usia 0-12 bulan. Merangsang tumbuh kembang dan memperkuat imunitas si kecil.',
                'id_terapis'   => 4,
                'price'        => 130000,
                'id_location'  => $locationId,
                'is_active'    => true,
            ],
            [
                'name_service' => 'Bekam Basah Premium',
                'id_category'  => $categories['bekam-umum']     ?? null,
                'description'  => 'Bekam basah premium dengan titik lebih banyak, cocok untuk keluhan berat dan detoksifikasi menyeluruh.',
                'id_terapis'   => 3,
                'price'        => 250000,
                'id_location'  => $locationId,
                'is_active'    => true,
            ],
        ];

        foreach ($services as $svc) {
            Service::create($svc);
        }
    }
}
