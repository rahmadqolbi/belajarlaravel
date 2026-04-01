<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerpindahanStok extends Model
{
    protected $table = 'perpindahanstok';
    protected $fillable = [
        'kode_transfer',
        'outlet_asal_id',
        'outlet_tujuan_id',
        'user_id',
        'tanggal',
        'status',
        'catatan',
    ];

    // public function outletAsal(){
    //     return $this->belongsTo(Outlet::class, 'outlet_asal_id');
    // }
}
