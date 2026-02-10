<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    protected $table = "outlet";
    protected $fillable = [
        'kode_outlet',
        'nama_outlet',
        'alamat',
        'penanggung_jawab',
        'telepon',
        'status'
    ];
    public function tujuan(){
        return $this->morphMany(BarangMasuk::class, 'outlet_id');
    }
}
