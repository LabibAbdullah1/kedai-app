<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';

    protected $fillable = [
        'nama_menu',
        'kategori',
        'harga',
        'stok',
        'status'
    ];

    // Menu ada di banyak detail pesanan
    public function pesananDetail()
    {
        return $this->hasMany(PesananDetail::class, 'menu_id');
    }
}
