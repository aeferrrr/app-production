<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk'; // Nama tabel di database
    protected $primaryKey = 'id_produk'; // Primary key
    public $timestamps = true; // Aktifkan timestamps

    protected $fillable = ['kode_produk', 'nama_produk', 'harga_jual']; // Kolom yang bisa diisi

    // Relasi ke tabel produk_bahan
    public function produkBahan()
    {
        return $this->hasMany(ProdukBahan::class, 'id_produk', 'id_produk');
    }

    // Relasi ke Bahan melalui ProdukBahan
    public function bahan()
    {
        return $this->belongsToMany(Bahan::class, 'produk_bahan', 'id_produk', 'id_bahan');
    }
}
