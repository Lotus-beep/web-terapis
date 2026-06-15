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
        'description',
        'header_content',
        'icon',
        'image',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Auto-generate slug dari name saat create
    protected static function booted(): void
    {
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

        static::updating(function ($category) {
            if ($category->isDirty('name') && !$category->isDirty('slug')) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class, 'id_category');
    }

    // Gambar: pakai upload jika ada, fallback ke default per slug
    public function getDisplayImageAttribute(): string
    {
        if ($this->image) {
            return 'storage/' . $this->image;
        }

        // Default images berdasarkan slug
        $defaults = [
            'bekam-umum'          => 'image/Bekam Foto.jpeg',
            'fashdu'              => 'image/Tempat Bekam 2.jpeg',
            'gurah'               => 'image/Rumah Bekam 3.jpeg',
            'akupuntur'           => 'image/jenis Layanan.png',
            'pijat-syaraf-kejepit'=> 'image/tempat Bekam.jpeg',
            'pijat-bayi-anak'     => 'image/Layanan Pijat Bayi & Anak.jpeg',
        ];

        return $defaults[$this->slug] ?? 'image/Bekam Foto.jpeg';
    }
}
