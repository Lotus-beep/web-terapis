<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory;

    protected $table = 'location';

    protected $fillable = [
        'name_location',
    ];

    public function services(): HasMany
    {
        return $this->hasMany(Service::class, 'id_location');
    }
}
