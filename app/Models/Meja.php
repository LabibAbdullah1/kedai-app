<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    use HasFactory;

    protected $table = 'meja';

    protected $fillable = [
        'nomor_meja',
        'kapasitas',
        'status',
        'booking_mulai',
        'booking_selesai'
    ];

    // Satu meja bisa digunakan untuk banyak pesanan
    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'meja_id');
    }

    // Satu meja bisa memiliki banyak booking
    public function booking()
    {
        return $this->hasMany(Booking::class, 'meja_id');
    }

    // Satu meja bisa punya banyak riwayat pembersihan
    public function pembersihan()
    {
        return $this->hasMany(Pembersihan::class, 'meja_id');
    }
}
