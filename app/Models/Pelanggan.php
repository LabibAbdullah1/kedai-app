<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';

    protected $fillable = [
        'nama',
        'no_hp',
        'catatan',
        'tanggal_datang'
    ];

    // Pelanggan punya banyak pesanan
    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'pelanggan_id');
    }

    // Pelanggan bisa melakukan banyak booking
    public function booking()
    {
        return $this->hasMany(Booking::class, 'pelanggan_id');
    }
}
