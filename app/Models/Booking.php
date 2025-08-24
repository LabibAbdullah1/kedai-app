<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'booking';

    protected $fillable = [
        'pelanggan_id',
        'meja_id',
        'booking_mulai',
        'booking_selesai',
        'status'
    ];

    // Booking milik pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    // Booking menggunakan meja
    public function meja()
    {
        return $this->belongsTo(Meja::class, 'meja_id');
    }
}
