<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ServiceCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name'        => 'Bekam Umum',
                'slug'        => 'bekam-umum',
                'description' => 'Terapi bekam basah (wet cupping) untuk mengeluarkan darah kotor dan racun dari tubuh. Efektif untuk berbagai keluhan kesehatan kronis maupun akut.',
                'icon'        => 'bi-droplet-fill',
                'sort_order'  => 1,
            ],
            [
                'name'        => 'Fashdu',
                'slug'        => 'fashdu',
                'description' => 'Fashdu atau bekam kering adalah terapi menghisap kulit tanpa sayatan. Melancarkan peredaran darah dan mengurangi rasa nyeri otot.',
                'icon'        => 'bi-wind',
                'sort_order'  => 2,
            ],
            [
                'name'        => 'Gurah',
                'slug'        => 'gurah',
                'description' => 'Terapi gurah untuk membersihkan saluran pernapasan bagian atas dari lendir dan kotoran. Membantu mengatasi sinusitis dan alergi.',
                'icon'        => 'bi-water',
                'sort_order'  => 3,
            ],
            [
                'name'        => 'Akupuntur',
                'slug'        => 'akupuntur',
                'description' => 'Terapi akupuntur dengan jarum halus pada titik-titik meridian tubuh untuk menyeimbangkan energi dan mengatasi berbagai keluhan kesehatan.',
                'icon'        => 'bi-plus-circle-fill',
                'sort_order'  => 4,
            ],
            [
                'name'        => 'Pijat Syaraf Kejepit',
                'slug'        => 'pijat-syaraf-kejepit',
                'description' => 'Terapi pijat khusus untuk mengatasi syaraf kejepit, nyeri punggung, pinggang, dan leher dengan teknik yang aman dan efektif.',
                'icon'        => 'bi-activity',
                'sort_order'  => 5,
            ],
            [
                'name'        => 'Pijat Bayi & Anak',
                'slug'        => 'pijat-bayi-anak',
                'description' => 'Layanan pijat khusus bayi dan anak dengan teknik lembut dan aman. Membantu tumbuh kembang si kecil secara optimal.',
                'icon'        => 'bi-emoji-smile-fill',
                'sort_order'  => 6,
            ],
        ];

        foreach ($categories as $cat) {
            DB::table('service_categories')->insertOrIgnore([
                'name'        => $cat['name'],
                'slug'        => $cat['slug'],
                'description' => $cat['description'],
                'icon'        => $cat['icon'],
                'image'       => null,
                'is_active'   => true,
                'sort_order'  => $cat['sort_order'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
