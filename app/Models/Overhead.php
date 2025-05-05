<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Overhead extends Model
{
    protected $table = 'overhead'; // Nama tabel di database
    protected $primaryKey = 'id_bop'; // Primary Key
    public $timestamps = true; // Aktifkan created_at & updated_at

    protected $fillable = [
        'nama_bop',
        'biaya_bop',
        'keterangan_bop',
    ];
}
