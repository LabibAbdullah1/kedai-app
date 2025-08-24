<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    use HasFactory;

    protected $table = 'gaji';

    protected $fillable = [
        'user_id',
        'gaji_pokok',
        'lembur',
        'total_gaji',
        'bulan'
    ];

    // Gaji milik karyawan tertentu
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
