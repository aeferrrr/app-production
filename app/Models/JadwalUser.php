<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class JadwalUser extends Pivot
{
    protected $table = 'jadwal_user';

    protected $fillable = [
        'id_jadwal',
        'id_user',
        'upah',
    ];

    public $timestamps = true; // Karena tabel kamu punya created_at & updated_at
}
