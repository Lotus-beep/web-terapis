<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterSesi extends Model
{
    protected $table = 'master_sesi';

    protected $fillable = [
        'nama_sesi',
        'jam_mulai',
        'jam_selesai',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];
}
