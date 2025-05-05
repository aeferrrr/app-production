<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bahan extends Model
{
    protected $table = 'bahan'; // Nama tabel di database
    protected $primaryKey = 'id_bahan'; // Primary Key
    public $timestamps = true; // Aktifkan created_at & updated_at

    protected $fillable = [
        'kode_bahan',
        'nama_bahan',
        'harga_bahan',
        'satuan',
    ];

    // Relasi ke tabel produk_bahan
    public function produkBahan()
    {
        return $this->hasMany(ProdukBahan::class, 'id_bahan', 'id_bahan');
    }

    // Relasi ke Produk melalui ProdukBahan
    public function produk()
    {
        return $this->belongsToMany(Produk::class, 'produk_bahan', 'id_bahan', 'id_produk');
    }
}
