<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokOutlet extends Model
{
    protected $table = "stok_outlet";
    protected $fillable = [
        'produk_id',
        'outlet_id',
        'stok',
    ];
}
