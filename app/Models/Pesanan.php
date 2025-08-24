<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';

    protected $fillable = [
        'pelanggan_id',
        'meja_id',
        'waiter_id',
        'total_harga',
        'status'
    ];

    // Pesanan milik pelanggan
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    // Pesanan menggunakan meja tertentu
    public function meja()
    {
        return $this->belongsTo(Meja::class, 'meja_id');
    }

    // Pesanan dibuat oleh waiter tertentu
    public function waiter()
    {
        return $this->belongsTo(User::class, 'waiter_id');
    }

    // Pesanan punya banyak detail menu
    public function detail()
    {
        return $this->hasMany(PesananDetail::class, 'pesanan_id');
    }

    // Pesanan diproses di dapur
    public function dapur()
    {
        return $this->hasOne(Dapur::class, 'pesanan_id');
    }
}
