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
        "harga",
        "harga_modal"
    ];
//     public function produk()
// {
//     return $this->belongsTo(ProdukModel::class);
// }
protected $casts = [
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
];


  public function produk()
{
    return $this->belongsTo(ProdukModel::class, 'produk_id', 'id');
}
    //  public function kategori()
    // {
    //     return $this->belongsTo(Kategori::class, 'kategori_id');
    // }

//hasOne → satu punya satu

// hasMany → satu punya banyak

// belongsTo → data ini milik siapa
}
