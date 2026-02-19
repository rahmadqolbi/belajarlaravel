<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangMasukDetail extends Model
{
    protected $table = 'barangmasukdetail';
    protected $fillable = [
        'barang_masuk_id',
        'barang_id',
        'qty',
        'harga',
    ];






}
