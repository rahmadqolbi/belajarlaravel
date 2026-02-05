<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gudang extends Model
{
    protected $table = "gudang";
    protected $fillable = [
        'kode_gudang',
        'nama_gudang',
        'alamat',
        'penanggung_jawab',
        'telepon',
        'status'
    ];
}
