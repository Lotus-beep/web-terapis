<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            ['name_location' => 'Cabang Utama - Jakarta Pusat'],
            ['name_location' => 'Cabang Selatan - Jakarta Selatan'],
            ['name_location' => 'Cabang Timur - Jakarta Timur'],
        ];

        foreach ($locations as $location) {
            Location::create($location);
        }
    }
}
