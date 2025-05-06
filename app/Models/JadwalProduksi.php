<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class JadwalProduksi extends Model
{
    protected $table = 'jadwal_produksi';

    protected $primaryKey = 'id_jadwal';

    protected $fillable = [
        'id_pesanan',
        'tanggal_mulai',
        'tanggal_selesai',
        'status_jadwal',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'jadwal_user', 'id_jadwal', 'id_user')
                    ->withPivot('upah')
                    ->withTimestamps();
    }

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }

    public function jadwalUser(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'jadwal_user', 'id_jadwal', 'id_user')
                    ->withPivot('upah')
                    ->withTimestamps();
    }
    
}
