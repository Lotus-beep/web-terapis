<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username' => 'Admin',
            'email' => 'admin@bekam.com',
            'password' => Hash::make('password'),
            'no_telepon' => '081234567890',
            'alamat' => 'Jl. Admin No. 1, Jakarta',
            'role_users' => 'admin',
        ]);
    }
}
