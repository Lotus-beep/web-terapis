<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Terapis;
use App\Models\User;

class TerapisSeeder extends Seeder
{
    public function run(): void
    {
        $terapisData = [
            [
                'username'   => 'Ahmad Fauzi',
                'email'      => 'ahmad@bekam.com',
                'password'   => Hash::make('password'),
                'no_telepon' => '081111111111',
                'alamat'     => 'Jl. Terapis No. 1, Jakarta',
                'gender'     => 'laki-laki',
                'rating'     => 4.50,
            ],
            [
                'username'   => 'Budi Santoso',
                'email'      => 'budi@bekam.com',
                'password'   => Hash::make('password'),
                'no_telepon' => '082222222222',
                'alamat'     => 'Jl. Terapis No. 2, Bandung',
                'gender'     => 'laki-laki',
                'rating'     => 4.20,
            ],
            [
                'username'   => 'Citra Dewi',
                'email'      => 'citra@bekam.com',
                'password'   => Hash::make('password'),
                'no_telepon' => '083333333333',
                'alamat'     => 'Jl. Terapis No. 3, Jakarta',
                'gender'     => 'perempuan',
                'rating'     => 4.80,
            ],
            [
                'username'   => 'Dewi Lestari',
                'email'      => 'dewi@bekam.com',
                'password'   => Hash::make('password'),
                'no_telepon' => '084444444444',
                'alamat'     => 'Jl. Terapis No. 4, Jakarta',
                'gender'     => 'perempuan',
                'rating'     => 4.60,
            ],
        ];

        foreach ($terapisData as $data) {
            Terapis::create($data);

            // Buat user account dengan role terapis
            User::create([
                'username'   => $data['username'],
                'email'      => $data['email'],
                'password'   => $data['password'],
                'no_telepon' => $data['no_telepon'],
                'alamat'     => $data['alamat'],
                'gender'     => $data['gender'],
                'role_users' => 'terapis',
            ]);
        }
    }
}
