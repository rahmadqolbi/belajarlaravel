<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'penjualan';
    protected $fillable = [
        'kode',
        'tanggal',
        'total',
        'dibayar',
        'metode_pembayaran',
        'user_id',
        'status'
    ];
    public function penjualan_detail(){
        return $this->hasMany(PenjualanDetail::class);
    }
    public function user()
{
    return $this->belongsTo(User::class);
}

}
