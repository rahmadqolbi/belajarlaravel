<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    protected $table = 'penjualan_detail';
    protected $fillable = [
        'penjualan_id',
        'produk_id',
        'qty',
        'harga',
        'subtotal',
    ];
    // RELASI: Detail milik Penjualan
   public function produk()
{
    return $this->belongsTo(ProdukModel::class, 'produk_id');
}

}
