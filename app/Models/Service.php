<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $table = 'service';

    protected $fillable = [
        'name_service',
        'date_service',
        'status_payment',
        'time_service',
        'id_terapis',
        'price',
        'id_location',
    ];

    protected function casts(): array
    {
        return [
            'date_service' => 'date',
            'price' => 'decimal:2',
        ];
    }

    public function terapis(): BelongsTo
    {
        return $this->belongsTo(Terapis::class, 'id_terapis');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'id_location');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'id_service');
    }
}
