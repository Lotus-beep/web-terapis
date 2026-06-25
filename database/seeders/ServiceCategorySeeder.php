<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceCategorySeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            // ========== KATEGORI: BEKAM ==========
            [
                'name'           => 'Bekam Umum',
                'slug'           => 'bekam-umum',
                'category'       => 'bekam',
                'header_content' => 'Bekam Basah (Wet Cupping)',
                'description'    => 'Terapi bekam basah dengan teknik penghisapan dan pengeluaran darah kotor dari tubuh. Efektif untuk menjaga kesehatan, meningkatkan imunitas, dan mengeluarkan racun.',
                'icon'           => 'bi-droplet-fill',
                'sort_order'     => 1,
                'price'          => 150000,
            ],
            [
                'name'           => 'Bekam Kering',
                'slug'           => 'bekam-kering',
                'category'       => 'bekam',
                'header_content' => 'Bekam Kering (Dry Cupping)',
                'description'    => 'Terapi bekam tanpa pengeluaran darah, hanya penghisapan untuk melancarkan peredaran darah dan meredakan nyeri otot.',
                'icon'           => 'bi-hurricane',
                'sort_order'     => 2,
                'price'          => 100000,
            ],
            [
                'name'           => 'Bekam Anak',
                'slug'           => 'bekam-anak',
                'category'       => 'bekam',
                'header_content' => 'Bekam untuk Anak-Anak',
                'description'    => 'Terapi bekam yang dirancang khusus untuk anak-anak dengan teknik lebih lembut dan aman, membantu meningkatkan imunitas dan kesehatan si kecil.',
                'icon'           => 'bi-person-hearts',
                'sort_order'     => 3,
                'price'          => 120000,
            ],
            [
                'name'           => 'Bekam Wajah',
                'slug'           => 'bekam-wajah',
                'category'       => 'bekam',
                'header_content' => 'Bekam Facial / Kecantikan',
                'description'    => 'Terapi bekam pada area wajah untuk mencerahkan kulit, mengurangi bekas jerawat, dan meremajakan wajah secara alami.',
                'icon'           => 'bi-stars',
                'sort_order'     => 4,
                'price'          => 130000,
            ],

            // ========== KATEGORI: NON BEKAM ==========
            [
                'name'           => 'Fashdu',
                'slug'           => 'fashdu',
                'category'       => 'non-bekam',
                'header_content' => 'Fashdu (Pembekuan Darah)',
                'description'    => 'Terapi fashdu adalah metode pengobatan dengan cara mengeluarkan darah melalui pembuluh vena yang dipotong. Salah satu terapi tertua dalam pengobatan Islam.',
                'icon'           => 'bi-activity',
                'sort_order'     => 5,
                'price'          => 175000,
            ],
            [
                'name'           => 'Gurah',
                'slug'           => 'gurah',
                'category'       => 'non-bekam',
                'header_content' => 'Gurah (Terapi Hidung & Tenggorokan)',
                'description'    => 'Terapi gurah menggunakan ramuan herbal yang diteteskan ke hidung untuk membersihkan lendir dan racun dari saluran pernapasan, tenggorokan, dan kepala.',
                'icon'           => 'bi-wind',
                'sort_order'     => 6,
                'price'          => 140000,
            ],
            [
                'name'           => 'Akupuntur',
                'slug'           => 'akupuntur',
                'category'       => 'non-bekam',
                'header_content' => 'Akupuntur (Tusuk Jarum)',
                'description'    => 'Terapi akupuntur dengan memasukkan jarum tipis ke titik-titik meridian tubuh untuk melancarkan energi, mengurangi nyeri, dan menyeimbangkan fungsi organ.',
                'icon'           => 'bi-lightning-fill',
                'sort_order'     => 7,
                'price'          => 160000,
            ],
            [
                'name'           => 'Pijat Syaraf',
                'slug'           => 'pijat-syaraf',
                'category'       => 'non-bekam',
                'header_content' => 'Pijat Refleksi Syaraf',
                'description'    => 'Terapi pijat yang berfokus pada titik-titik syaraf dan refleksi untuk meredakan ketegangan, sakit kepala, nyeri punggung, dan meningkatkan sirkulasi.',
                'icon'           => 'bi-diagram-3-fill',
                'sort_order'     => 8,
                'price'          => 130000,
            ],
            [
                'name'           => 'Pijat Anak',
                'slug'           => 'pijat-anak',
                'category'       => 'non-bekam',
                'header_content' => 'Pijat Bayi & Anak',
                'description'    => 'Terapi pijat lembut untuk bayi dan anak yang dirancang untuk mendukung tumbuh kembang, meningkatkan imunitas, dan memperkuat ikatan batin.',
                'icon'           => 'bi-emoji-smile-fill',
                'sort_order'     => 9,
                'price'          => 110000,
            ],
            [
                'name'           => 'Ruqyah',
                'slug'           => 'ruqyah',
                'category'       => 'non-bekam',
                'header_content' => 'Ruqyah Syariyyah',
                'description'    => 'Terapi ruqyah syariyyah menggunakan ayat-ayat Al-Quran dan doa-doa yang sah untuk penyembuhan gangguan spiritual dan psikis sesuai sunnah.',
                'icon'           => 'bi-book-fill',
                'sort_order'     => 10,
                'price'          => 0,
            ],
        ];

        foreach ($services as $svc) {
            DB::table('service_categories')->insertOrIgnore([
                'name'           => $svc['name'],
                'slug'           => $svc['slug'],
                'category'       => $svc['category'],
                'header_content' => $svc['header_content'],
                'description'    => $svc['description'],
                'icon'           => $svc['icon'],
                'image'          => null,
                'is_active'      => true,
                'sort_order'     => $svc['sort_order'],
                'price'          => $svc['price'],
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }
    }
}
