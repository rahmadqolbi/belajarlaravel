<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = "kategori";
    protected $fillable = ["nama_kategori"];

     public function produk()
    {
        // Kategori ini memiliki banyak Produk,
        // yang dihubungkan lewat kolom kategori_id di tabel produk
        return $this->hasMany(ProdukModel::class, 'kategori_id');
    }
}
