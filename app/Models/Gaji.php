<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    protected $table = 'gaji';
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_hadir',
        'total_jam_kerja',
        'total_lembur',
        'gaji_pokok',
        'uang_lembur',
        'total_gaji',
        'periode_gaji',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
