<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePenjualanRequest;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
// use App\Models\PenjualanDetail;
use App\Models\ProdukModel;
use Illuminate\Http\Request;
// Remove this line if you are not using Auth::... in the file
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('penjualan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tanggal = date('Ymd');
    $jumlahHariIni = Penjualan::whereDate('created_at', today())->count();
    $urutan = str_pad($jumlahHariIni + 1, 3, '0', STR_PAD_LEFT);
    $kode = 'TRX' . $tanggal . $urutan;

    $produk = ProdukModel::all(); // ambil semua produk

    return view('penjualan.add', compact('kode', 'produk'));
    }

    /**
     * Store a newly created resource in storage.
     */
  public function store(StorePenjualanRequest $request)
{
    DB::transaction(function () use ($request) {

        $produkIds = $request->input('produk_id', []);
        $qtys = $request->input('qty', []);
        $total = 0;

        foreach ($produkIds as $i => $id) {

            if (!$id) continue;

            $produk = ProdukModel::lockForUpdate()->findOrFail($id);
            $qty = $qtys[$i] ?? 0;

            // ✅ VALIDASI STOK
            if ($qty > $produk->stok) {
                throw ValidationException::withMessages([
                    'stok' => "Stok {$produk->nama_barang} tidak mencukupi"
                ]);
            }
        }

        // ✅ kalau lolos validasi baru buat penjualan
        $penjualan = Penjualan::create([
            'kode' => $request->kode,
            'tanggal' => $request->tanggal,
            'total' => 0,
            'dibayar' => $request->dibayar,
            'metode_pembayaran' => $request->metode_pembayaran,
            'user_id' => auth()->id(),
        ]);

        foreach ($produkIds as $i => $id) {

            if (!$id) continue;

            $produk = ProdukModel::lockForUpdate()->findOrFail($id);
            $qty = $qtys[$i] ?? 0;

            $harga = $produk->harga;
            $subtotal = $harga * $qty;
            $total += $subtotal;

            PenjualanDetail::create([
                'penjualan_id' => $penjualan->id,
                'produk_id' => $id,
                'qty' => $qty,
                'harga' => $harga,
                'subtotal' => $subtotal,
            ]);

            $produk->decrement('stok', $qty);
        }

        $penjualan->update([
            'total' => $total
        ]);
    });

    return redirect()->route('penjualan')
        ->with('success', 'Transaksi Berhasil');
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
