<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterSesi;

class MasterSesiSeeder extends Seeder
{
    public function run(): void
    {
        $sessions = [
            ['nama_sesi' => 'Sesi 1', 'jam_mulai' => '08:00', 'jam_selesai' => '09:00'],
            ['nama_sesi' => 'Sesi 2', 'jam_mulai' => '09:30', 'jam_selesai' => '10:30'],
            ['nama_sesi' => 'Sesi 3', 'jam_mulai' => '11:00', 'jam_selesai' => '12:00'],
            ['nama_sesi' => 'Sesi 4', 'jam_mulai' => '12:30', 'jam_selesai' => '13:30'],
            ['nama_sesi' => 'Sesi 5', 'jam_mulai' => '14:00', 'jam_selesai' => '15:00'],
            ['nama_sesi' => 'Sesi 6', 'jam_mulai' => '15:30', 'jam_selesai' => '16:30'],
            ['nama_sesi' => 'Sesi 7', 'jam_mulai' => '17:00', 'jam_selesai' => '18:00'],
            ['nama_sesi' => 'Sesi 8', 'jam_mulai' => '18:30', 'jam_selesai' => '19:30'],
            ['nama_sesi' => 'Sesi 9', 'jam_mulai' => '20:00', 'jam_selesai' => '21:00'],
        ];

        foreach ($sessions as $index => $s) {
            MasterSesi::updateOrCreate(
                ['jam_mulai' => $s['jam_mulai'], 'jam_selesai' => $s['jam_selesai']],
                ['nama_sesi' => $s['nama_sesi'] ?: 'Sesi ' . ($index + 1), 'active' => true]
            );
        }
    }
}
