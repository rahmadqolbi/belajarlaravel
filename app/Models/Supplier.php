<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'supplier';
    protected $fillable = [
        'nama_supplier',
        'no_hp',
        'alamat',
    ];

     public function supplier()
    {
        // Kategori ini memiliki banyak Produk,
        // yang dihubungkan lewat kolom supplier_id di tabel BarangMasuk
        return $this->hasMany(BarangMasuk::class, 'supplier_id');
    }
}
