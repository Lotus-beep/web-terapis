<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ServiceCategory extends Model
{
    protected $table = 'service_categories';

    protected $fillable = [
        'name',
        'slug',
        'category',
        'header_content',
        'description',
        'icon',
        'image',
        'price',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price'     => 'decimal:2',
    ];

    // Auto-generate slug dari name saat create
    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('name') && !$model->isDirty('slug')) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    // Relasi ke galeri foto
    public function images(): HasMany
    {
        return $this->hasMany(ServiceImage::class, 'service_category_id')
                    ->orderBy('sort_order')
                    ->orderBy('id');
    }

    public function primaryImage(): ?ServiceImage
    {
        return $this->images()->where('is_primary', true)->first()
            ?? $this->images()->first();
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(\App\Models\Booking::class, 'id_service');
    }

    // Accessor name_service untuk kompatibilitas view booking
    public function getNameServiceAttribute(): string
    {
        return $this->name;
    }

    // Label kategori
    public function getCategoryLabelAttribute(): string
    {
        return match($this->category) {
            'bekam'     => 'Bekam',
            'non-bekam' => 'Non Bekam',
            default     => 'Lainnya',
        };
    }

    // Warna badge kategori
    public function getCategoryColorAttribute(): string
    {
        return match($this->category) {
            'bekam'     => '#1b6b3a',
            'non-bekam' => '#2563eb',
            default     => '#6b7280',
        };
    }

    /**
     * Gambar utama untuk ditampilkan di card.
     * Prioritas: foto upload pertama → foto default per kategori
     */
    public function getDisplayImageAttribute(): string
    {
        // Coba ambil dari galeri
        $primary = $this->images()->first();
        if ($primary) {
            return asset('storage/' . $primary->path);
        }

        // Fallback: kolom image lama (jika ada)
        if ($this->image) {
            return asset('storage/' . $this->image);
        }

        // Default per kategori
        return asset($this->category === 'bekam'
            ? 'image/Bekam Foto.jpeg'
            : 'image/Tempat Bekam 2.jpeg'
        );
    }
}
