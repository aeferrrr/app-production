<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk'; // Nama tabel di database
    protected $primaryKey = 'id_produk'; // Primary key
    public $timestamps = true; // Aktifkan timestamps

    protected $fillable = ['kode_produk', 'nama_produk']; // Kolom yang bisa diisi
}
