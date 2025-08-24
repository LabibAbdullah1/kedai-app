<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dapur extends Model
{
    use HasFactory;

    protected $table = 'dapur';

    protected $fillable = [
        'pesanan_id',
        'koki_id',
        'status'
    ];

    // Dapur memproses pesanan
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }

    // Dapur dikerjakan oleh koki
    public function koki()
    {
        return $this->belongsTo(User::class, 'koki_id');
    }
}
