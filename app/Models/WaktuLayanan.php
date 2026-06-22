<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WaktuLayanan extends Model
{
    protected $table = 'waktu_layanan';

    protected $fillable = [
        'tanggal',
        'waktu_buka',
        'waktu_tutup',
        'maximal',
        'active',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'active'  => 'boolean',
    ];

    public function waktuBoking(): HasMany
    {
        return $this->hasMany(WaktuBoking::class, 'id_waktu_layanan');
    }

    /**
     * Generate slot jam dari waktu_buka ke waktu_tutup per 1 jam
     */
    public function generateSlots(): array
    {
        $slots = [];
        $current = \Carbon\Carbon::parse($this->tanggal->format('Y-m-d') . ' ' . $this->waktu_buka);
        $end     = \Carbon\Carbon::parse($this->tanggal->format('Y-m-d') . ' ' . $this->waktu_tutup);

        while ($current->copy()->addHour()->lte($end)) {
            $slots[] = $current->format('H:i');
            $current->addHour();
        }

        return $slots;
    }
}
