<?php

namespace Database\Seeders;

// use Illuminate\Container\Attributes\DB;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('produk')->insert([
    [
        'kategori_id' => '1',
        'kode' => 'BRGFNXA03',
        'nama_barang' => 'Keripik Pedas',
        'deskripsi' => '',
        'stok' => 0,
        'harga' => 10000,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'kategori_id' => '1',
        'kode' => 'BRGFNXA04',
        'nama_barang' => 'Keripik manis',
        'deskripsi' => '',
        'stok' => 0,
        'harga' => 10000,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'kategori_id' => '1',
        'kode' => 'BRGFNXA05',
        'nama_barang' => 'Keripik asam manis',
        'deskripsi' => '',
        'stok' => 0,
        'harga' => 10000,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'kategori_id' => '1',
        'kode' => 'BRGFNXA06',
        'nama_barang' => 'Keripik kering',
        'deskripsi' => '',
        'stok' => 0,
        'harga' => 10000,
        'created_at' => now(),
        'updated_at' => now(),
    ]
]);
    }
}
