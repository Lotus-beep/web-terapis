<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WaktuBoking extends Model
{
    protected $table = 'waktu_boking';

    protected $fillable = [
        'id_waktu_layanan',
        'id_ruangan',
        'kode_waktu_boking',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function waktuLayanan(): BelongsTo
    {
        return $this->belongsTo(WaktuLayanan::class, 'id_waktu_layanan');
    }

    public function ruangan(): BelongsTo
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'id_waktu_boking');
    }

    /**
     * Cek apakah slot ini sudah penuh (booking aktif >= kapasitas ruangan)
     */
    public function isFull(): bool
    {
        $booked = $this->bookings()
            ->whereNotIn('status_service', ['cancelled'])
            ->count();

        return $booked >= $this->ruangan->maximal;
    }

    /**
     * Hitung sisa kursi
     */
    public function sisaKursi(): int
    {
        $booked = $this->bookings()
            ->whereNotIn('status_service', ['cancelled'])
            ->count();

        return max(0, $this->ruangan->maximal - $booked);
    }
}
