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
        'id_category',
        'description',
        'image',
        'is_active',
        'price',
        'id_terapis',
        'id_location',
    ];

    protected $casts = [
        'price'     => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // --- Accessors ---

    public function getCategoryLabelAttribute(): string
    {
        return $this->category?->name ?? '-';
    }

    public function getCategoryIconAttribute(): string
    {
        return $this->category?->icon ?? 'bi-heart-pulse-fill';
    }

    /**
     * Gambar layanan: pakai upload jika ada,
     * fallback ke gambar kategori, fallback ke default
     */
    public function getCategoryImageAttribute(): string
    {
        if ($this->image) {
            return 'storage/' . $this->image;
        }
        return $this->category?->display_image ?? 'image/Bekam Foto.jpeg';
    }

    // --- Relations ---

    public function category(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class, 'id_category');
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

    // --- Helpers ---

    /**
     * Cek apakah slot tanggal+jam sudah dipesan
     */
    public function isSlotTaken(string $date, string $time, ?int $excludeBookingId = null): bool
    {
        $query = $this->bookings()
            ->where('date_booking', $date)
            ->where('time_booking', $time)
            ->whereNotIn('status_service', ['cancelled']);

        if ($excludeBookingId) {
            $query->where('id', '!=', $excludeBookingId);
        }

        return $query->exists();
    }
}
