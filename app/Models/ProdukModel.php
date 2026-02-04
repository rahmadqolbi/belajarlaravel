<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukModel extends Model
{
    protected $table = "produk";
    protected $fillable = [
         'kategori_id',
        "kode",
        "nama_barang",
        "deskripsi",
        "stok",
        "harga",
    ];
    //  public function kategori()
    // {
    //     return $this->belongsTo(Kategori::class, 'kategori_id');
    // }

//hasOne → satu punya satu

// hasMany → satu punya banyak

// belongsTo → data ini milik siapa
}
