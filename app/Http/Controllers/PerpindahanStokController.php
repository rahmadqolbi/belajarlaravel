<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Models\PerpindahanStok;
use App\Models\PerpindahanStokDetail;
use App\Models\ProdukModel;
use App\Models\StokOutlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerpindahanStokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $outlet = Outlet::all();
        $produks = ProdukModel::all();
        $last = PerpindahanStok::latest('id')->first();
        $urut = ($last?->id ?? 0) + 1;
        $kode = 'TRF-' . str_pad($urut, 4, '0', STR_PAD_LEFT);
        return view('perpindahanstok.index', compact('outlet', 'produks', 'kode'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{


}

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{

    $request->validate([
        'outlet_asal_id'   => 'required|different:outlet_tujuan_id',
        'outlet_tujuan_id' => 'required',
        'produk_id'        => 'required|array',
        'qty'              => 'required|array',
    ]);

    try {
        DB::transaction(function () use ($request) {

            $transfer = PerpindahanStok::create([
                'kode_transfer'    => $request->kode_transfer,
                'tanggal'          => $request->tanggal,
                'outlet_asal_id'   => $request->outlet_asal_id,
                'outlet_tujuan_id' => $request->outlet_tujuan_id,
                'catatan'          => $request->catatan,
                'user_id'          => auth()->id(),
                'status'           => 'selesai',
            ]);

            foreach ($request->produk_id as $i => $produkId) {

                $qty = $request->qty[$i];

                if (!$produkId || !$qty) continue;

                $stokAsal = StokOutlet::where('produk_id', $produkId)
                    ->where('outlet_id', $request->outlet_asal_id)
                    ->first();

                if (!$stokAsal || $stokAsal->stok < $qty) {
                    throw new \Exception("Stok tidak cukup untuk produk ID $produkId!");
                }

                // Kurangi stok asal
                $stokAsal->update([
                    'stok' => $stokAsal->stok - $qty,
                ]);

                // Tambah stok tujuan
                $stokTujuan = StokOutlet::where('produk_id', $produkId)
                    ->where('outlet_id', $request->outlet_tujuan_id)
                    ->first();

                if ($stokTujuan) {
                    $stokTujuan->update([
                        'stok' => $stokTujuan->stok + $qty,
                    ]);
                } else {
                    StokOutlet::create([
                        'produk_id' => $produkId,
                        'outlet_id' => $request->outlet_tujuan_id,
                        'stok'      => $qty,
                    ]);
                }

                // ✅ Bug 1 diperbaiki: PerpindahanStokDetail bukan PerpindahanStok
                PerpindahanStokDetail::create([
                    'perpindahan_stok_id' => $transfer->id,
                    'produk_id'           => $produkId,
                    'qty'                 => $qty,
                ]);
            }
        });
        return redirect()->route('perpindahanstok')
            ->with('success', 'Transfer stok berhasil!');

    // ✅ Bug 2 diperbaiki: tangkap exception agar error terlihat
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', $e->getMessage())
            ->withInput();
    }
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
    public function getStok($produkId, $outletId)
{
    $stok = StokOutlet::
        where('produk_id', $produkId)
        ->where('outlet_id', $outletId)
        ->value('stok') ?? 0;

    return response()->json(['stok' => $stok]);
}
}
