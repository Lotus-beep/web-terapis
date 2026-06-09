<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            TerapisSeeder::class,
            LocationSeeder::class,
            ServiceCategorySeeder::class,
            ServiceSeeder::class,
            CustomerSeeder::class,
        ]);
    }
}
