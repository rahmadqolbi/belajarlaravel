<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\ProdukModel;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalPenjualan = Penjualan::sum('total');
        $transaksiBerhasil = Penjualan::where('status', 'BERHASIL')->count();
        $totalProduk = ProdukModel::count('nama_barang');
        $stokMenipis = ProdukModel::where('stok', '<=', 10)->count();
        return view('dashboard.index', compact('totalPenjualan', 'transaksiBerhasil', 'totalProduk', 'stokMenipis'));
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
