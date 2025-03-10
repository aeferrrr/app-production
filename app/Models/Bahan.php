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
}
