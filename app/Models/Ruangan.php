<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ruangan extends Model
{
    protected $table = 'ruangan';

    protected $fillable = [
        'nama_ruangan',
        'gender',
        'maximal',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function waktuBoking(): HasMany
    {
        return $this->hasMany(WaktuBoking::class, 'id_ruangan');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'id_ruangan');
    }

    /**
     * Hitung jumlah booking aktif di slot tertentu
     */
    public function bookingCountOnSlot(int $waktuBokingId): int
    {
        return $this->bookings()
            ->where('id_waktu_boking', $waktuBokingId)
            ->whereNotIn('status_service', ['cancelled'])
            ->count();
    }

    public function isFull(int $waktuBokingId): bool
    {
        return $this->bookingCountOnSlot($waktuBokingId) >= $this->maximal;
    }

    public function getGenderLabelAttribute(): string
    {
        return match($this->gender) {
            'laki-laki'  => 'Pria',
            'perempuan'  => 'Wanita',
            'campur'     => 'Campur',
            default      => $this->gender,
        };
    }
}
