<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'no_wa',
        'password',
        'role',
        // Hapus 'upah' karena itu milik pivot table, bukan di users
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function jadwalProduksi()
    {
        return $this->belongsToMany(JadwalProduksi::class, 'jadwal_user', 'id_user', 'id_jadwal')
                    ->withPivot('upah')
                    ->withTimestamps();
    }
}
