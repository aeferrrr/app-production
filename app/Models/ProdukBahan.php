<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukBahan extends Model
{
    protected $table = 'produk_bahan'; // Tabel penghubung antara produk dan bahan
    protected $primaryKey = 'id_produk_bahan'; // Primary key
    public $timestamps = true; // Aktifkan timestamps

    protected $fillable = ['id_produk', 'id_bahan', 'jumlah_bahan', 'satuan'];


    // Relasi ke Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    // Relasi ke Bahan
    public function bahan()
    {
        return $this->belongsTo(Bahan::class, 'id_bahan');
    }
}
