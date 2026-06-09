<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@rumahbekam.com'],
            [
                'username'   => 'Admin',
                'email'      => 'admin@rumahbekam.com',
                'password'   => Hash::make('Admin@1234'),
                'no_telepon' => '0895-360-776-606',
                'alamat'     => 'Jalan Daud No.12, Pasar Bunga Rawa Belong, Jakarta Barat 11540',
                'gender'     => 'laki-laki',
                'role_users' => 'admin',
            ]
        );
    }
}
