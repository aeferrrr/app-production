<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailUser extends Model
{
    use HasFactory;

    protected $table = 'detail_user';

    protected $fillable = [
        'id_user',
        'id_jadwal',
        'upah',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Relasi ke Jadwal Produksi
    public function jadwalProduksi()
    {
        return $this->belongsTo(JadwalProduksi::class, 'id_jadwal');
    }
}
