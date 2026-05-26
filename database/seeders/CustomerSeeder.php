<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            [
                'username' => 'Andi Wijaya',
                'email' => 'andi@customer.com',
                'password' => Hash::make('password'),
                'no_telepon' => '085111111111',
                'alamat' => 'Jl. Customer No. 1, Jakarta',
                'role_users' => 'customer',
            ],
            [
                'username' => 'Siti Rahayu',
                'email' => 'siti@customer.com',
                'password' => Hash::make('password'),
                'no_telepon' => '085222222222',
                'alamat' => 'Jl. Customer No. 2, Bandung',
                'role_users' => 'customer',
            ],
        ];

        foreach ($customers as $customer) {
            User::create($customer);
        }
    }
}
