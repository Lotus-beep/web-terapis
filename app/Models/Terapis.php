<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Terapis extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'terapis';

    protected $fillable = [
        'username',
        'email',
        'password',
        'no_telepon',
        'alamat',
        'rating',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'rating' => 'decimal:2',
        ];
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class, 'id_terapis');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'id_terapis');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'id_terapis');
    }
}
