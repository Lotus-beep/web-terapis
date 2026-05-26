<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name_service' => 'Bekam Basah Standar',
                'date_service' => '2025-02-01',
                'status_payment' => 'active',
                'time_service' => '09:00:00',
                'id_terapis' => 1,
                'price' => 150000,
                'id_location' => 1,
            ],
            [
                'name_service' => 'Bekam Kering Premium',
                'date_service' => '2025-02-01',
                'status_payment' => 'active',
                'time_service' => '10:00:00',
                'id_terapis' => 2,
                'price' => 100000,
                'id_location' => 2,
            ],
            [
                'name_service' => 'Bekam Wajah',
                'date_service' => '2025-02-02',
                'status_payment' => 'active',
                'time_service' => '13:00:00',
                'id_terapis' => 3,
                'price' => 200000,
                'id_location' => 1,
            ],
            [
                'name_service' => 'Bekam Punggung Full',
                'date_service' => '2025-02-03',
                'status_payment' => 'active',
                'time_service' => '14:00:00',
                'id_terapis' => 1,
                'price' => 250000,
                'id_location' => 3,
            ],
            [
                'name_service' => 'Bekam Kepala & Leher',
                'date_service' => '2025-02-04',
                'status_payment' => 'active',
                'time_service' => '15:00:00',
                'id_terapis' => 2,
                'price' => 175000,
                'id_location' => 2,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
