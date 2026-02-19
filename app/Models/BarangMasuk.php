<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    protected $table = "barangmasuk";
    protected $fillable = [
        'tanggal',
        'supplier_id',
        'tujuan_type',
        'tujuan_id',
        'no_dokumen',
        'keterangan',
        'status'
    ];
    protected $casts = [
    'tanggal' => 'datetime',
];
     public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function details()
    {
        return $this->belongsTo(BarangMasukDetail::class);
    }

    public function tujuan()
{
    return $this->morphTo();
}
    public function getTujuanSelectAttribute()
    {
        return match ($this->tujuan_type) {
            Gudang::class => 'gudang-'.$this->tujuan_id,
            Outlet::class => 'outlet-'.$this->tujuan_id,
            default       => null,
        };
    }

    // 🔑 UNTUK SIMPAN (STORE / UPDATE)
    public function setTujuanSelectAttribute($value)
    {
        [$type, $id] = explode('-', $value);

        $map = [
            'gudang' => Gudang::class,
            'outlet' => Outlet::class,
        ];

        $this->tujuan_type = $map[$type];
        $this->tujuan_id   = $id;
    }


}
