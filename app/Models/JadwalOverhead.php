<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalOverhead extends Model
{
    use HasFactory;

    protected $table = 'jadwal_overhead';

    protected $fillable = [
        'id_jadwal',
        'id_bop',
        'biaya',
    ];

    public function jadwal()
    {
        return $this->belongsTo(JadwalProduksi::class, 'id_jadwal', 'id_jadwal');
    }

    public function overhead()
    {
        return $this->belongsTo(Overhead::class, 'id_bop', 'id_bop');
    }
}
