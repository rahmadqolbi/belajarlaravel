<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerpindahanStokDetail extends Model
{
     protected $table = 'perpindahanstokdetail';
    protected $fillable = ['perpindahan_stok_id', 'produk_id', 'qty'];
}
