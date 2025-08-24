<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembersihan extends Model
{
    use HasFactory;

    protected $table = 'pembersihan';

    protected $fillable = [
        'meja_id',
        'pelayan_id',
        'status'
    ];

    // Pembersihan dilakukan pada meja tertentu
    public function meja()
    {
        return $this->belongsTo(Meja::class, 'meja_id');
    }

    // Pembersihan dilakukan oleh pelayan tertentu
    public function pelayan()
    {
        return $this->belongsTo(User::class, 'pelayan_id');
    }
}
