<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\ProdukModel;
use App\Models\StokOutlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalPenjualan = Penjualan::where('status', '!=', 'DIBATALKAN')->sum('total');
        $transaksiBerhasil = Penjualan::where('status', 'BERHASIL')->count();
        $totalProduk = ProdukModel::count('nama_barang');
         $stokMenipis = ProdukModel::where('stok', '<', 4)->sum('stok');

// Ganti dengan ini — ambil dari stok_outlet
$stokMenipis = StokOutlet::where('stok')
    ->where('stok', '<', 4)
    ->where('stok', '>', 0)
    ->count();
$totalProfit = PenjualanDetail::join('produk', 'penjualan_detail.produk_id', '=', 'produk.id')
    ->join('penjualan', 'penjualan_detail.penjualan_id', '=', 'penjualan.id')
    ->where('penjualan.status', '!=', 'batal')
    ->sum(DB::raw('(penjualan_detail.harga - produk.harga_modal) * penjualan_detail.qty'));

        return view('dashboard.index', compact('totalPenjualan', 'transaksiBerhasil', 'totalProduk', 'stokMenipis', 'totalProfit'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
