<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'gaji_pokok',
        'lembur_per_jam',
        'jam_masuk',
        'jam_keluar',
    ];

    protected $hidden = ['password', 'remember_token'];

    /** ============================
     * Relasi dengan Model Lain
     * ============================ */

    // User (waiter) memiliki banyak pesanan
    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'waiter_id');
    }

    // User memiliki banyak data gaji
    public function gaji()
    {
        return $this->hasMany(Gaji::class, 'user_id');
    }

    // User memiliki banyak absensi
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'user_id');
    }

    // Jika user adalah koki, punya banyak dapur (pesanan yg dibuat)
    public function dapur()
    {
        return $this->hasMany(Dapur::class, 'koki_id');
    }

    // Jika user adalah pelayan, punya banyak pembersihan meja
    public function pembersihan()
    {
        return $this->hasMany(Pembersihan::class, 'pelayan_id');
    }
}
