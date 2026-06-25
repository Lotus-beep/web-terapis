<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Ruangan;
use App\Models\Bed;
use App\Models\WaktuLayanan;
use App\Models\WaktuBoking;
use Carbon\Carbon;

class RuanganAndBedSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Rooms
        $roomsData = [
            // Pria
            ['nama_ruangan' => 'Ruang 1', 'gender' => 'laki-laki', 'maximal' => 3, 'active' => true],
            ['nama_ruangan' => 'Ruang 2', 'gender' => 'laki-laki', 'maximal' => 3, 'active' => true],
            ['nama_ruangan' => 'Ruang 3', 'gender' => 'laki-laki', 'maximal' => 4, 'active' => true],
            // Wanita
            ['nama_ruangan' => 'Ruang 4', 'gender' => 'perempuan', 'maximal' => 3, 'active' => true],
            ['nama_ruangan' => 'Ruang 5', 'gender' => 'perempuan', 'maximal' => 3, 'active' => true],
            ['nama_ruangan' => 'Ruang 6', 'gender' => 'perempuan', 'maximal' => 4, 'active' => true],
        ];

        $rooms = [];
        foreach ($roomsData as $rData) {
            $rooms[] = Ruangan::create($rData);
        }

        // 2. Seed Beds for each Room
        foreach ($rooms as $room) {
            $numBeds = $room->getRawOriginal('maximal');
            for ($i = 1; $i <= $numBeds; $i++) {
                Bed::create([
                    'id_ruangan' => $room->id,
                    'nama_bed'   => "Bed {$room->nama_ruangan}-{$i}",
                    'active'     => true,
                ]);
            }
        }

        // 3. Seed WaktuLayanan & WaktuBoking slots for the next 14 days
        $start = today();
        for ($day = 0; $day < 14; $day++) {
            $date = $start->copy()->addDays($day);
            
            $waktuLayanan = WaktuLayanan::create([
                'tanggal'     => $date,
                'waktu_buka'  => '08:00',
                'waktu_tutup' => '17:00',
                'maximal'     => 10,
                'active'      => true,
            ]);

            // Typical session hours matching the new slot layout:
            $hours = ['08:00', '09:30', '11:00', '12:30', '14:00', '15:30', '17:00', '18:30', '20:00'];

            foreach ($hours as $hour) {
                foreach ($rooms as $room) {
                    WaktuBoking::create([
                        'id_waktu_layanan'  => $waktuLayanan->id,
                        'id_ruangan'         => $room->id,
                        'kode_waktu_boking'  => $hour,
                        'active'             => true,
                    ]);
                }
            }
        }
    }
}
