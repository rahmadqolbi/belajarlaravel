<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBarangMasukRequest;
use App\Http\Requests\UpdateBarangMasukRequest;
use App\Models\BarangMasuk;
use App\Models\BarangMasukDetail;
use App\Models\Gudang;
use App\Models\Outlet;
use App\Models\ProdukModel;
use App\Models\Supplier;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $data = Supplier::all();
        // $gudangs = Gudang::all();
        // $outlets = Outlet::all();
        $max = 5;
        $data = BarangMasuk::latest()->paginate($max);
        return view('barangmasuk.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = Supplier::all();
        $gudangs = Gudang::all();
        $outlets = Outlet::all();
        $last = BarangMasuk::latest('id')->first();
        $urut = ($last?->id ?? 0) + 1;
        $produk = ProdukModel::all();
        $barangmasukdetail = BarangMasukDetail::all();
        $noDokumen = 'BM-'.str_pad($urut, 4, '0', STR_PAD_LEFT);
        return view('barangmasuk.add', compact('data', 'gudangs', 'outlets', 'noDokumen', 'produk', 'barangmasukdetail'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBarangMasukRequest $request)
{
    DB::transaction(function () use ($request) {

        [$type, $id] = explode('-', $request->tujuan_type);
        $type = strtolower($type);

        $tujuan = match($type) {
            'gudang' => Gudang::findOrFail($id),
            'outlet' => Outlet::findOrFail($id)
        };

        $barangMasuk = BarangMasuk::create([
            'tanggal'     => $request->tanggal,
            'supplier_id' => $request->supplier_id,
            'no_dokumen'  => $request->no_dokumen,
            'keterangan'  => $request->keterangan,
        ]);

         foreach ($request->barang_id as $i => $id) {

    $qty = $request->qty[$i]; // ← buat variabel dulu

    BarangMasukDetail::create([
        'barang_masuk_id' => $barangMasuk->id,
        'barang_id' => $id,
        'qty' => $qty,
        'harga' => $request->harga[$i],
    ]);

}


        $barangMasuk->tujuan()->associate($tujuan);
        $barangMasuk->save();

    });

    return redirect()->route('barangmasuk')
        ->with('success', 'Data berhasil ditambahkan');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
{
    $detail = BarangMasukDetail::where('barang_masuk_id', $id)->get();

     return view('barangmasuk.update', [
        'data'     => BarangMasuk::findOrFail($id),
        'detail'  => $detail,
        'supplier' => Supplier::all(),
        'gudangs'  => Gudang::all(),
        'outlets'  => Outlet::all(),
        'produk'  => ProdukModel::all(),

    ]);



}

    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(UpdateBarangMasukRequest $request, string $id)
{
    // =============================
    // 1. Ambil data lama
    // =============================
    $data = BarangMasuk::with('details')->findOrFail($id); // include details

    $oldStatus = $data->status; // status sebelum update

    [$type, $tujuanId] = explode('-', $request->tujuan_type);
    $type = strtolower($type);

    $tujuan = match ($type) {
        'gudang' => Gudang::findOrFail($tujuanId),
        'outlet' => Outlet::findOrFail($tujuanId),
    };

    // =============================
    // 2. Update Barang Masuk
    // =============================
    $data->tanggal     = $request->tanggal;
    $data->supplier_id = $request->supplier_id;
    $data->no_dokumen  = $request->no_dokumen;
    $data->keterangan  = $request->keterangan;
    $data->status      = $request->status;
    $data->tujuan()->associate($tujuan);
    $data->save();

    // =============================
    // 3. Hapus Detail Lama
    // =============================
    BarangMasukDetail::where('barang_masuk_id', $id)->delete();

    // =============================
    // 4. Simpan Detail Baru
    // =============================
    foreach ($request->barang_id as $key => $barangId) {

        BarangMasukDetail::create([
            'barang_masuk_id' => $data->id,
            'barang_id'       => $barangId,
            'qty'             => $request->qty[$key],
            'harga'           => $request->harga[$key],
        ]);
    }

    // Ambil detail baru setelah simpan
    $details = BarangMasukDetail::where('barang_masuk_id', $data->id)->get();
    // =============================
    // 5. Tambah stok jika status berubah DRAFT -> APPROVED
    // =============================
    if ($oldStatus == 'DRAFT' && $request->status == 'APPROVED') {
    foreach ($details as $detail) {
        $produk = ProdukModel::find($detail->barang_id);
        $produk->stok += $detail->qty;
        $produk->save();
    }
}



    return redirect()
        ->route('barangmasuk')
        ->with('success', 'Data Berhasil Di Edit');

}




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        BarangMasuk::where('id', $id)->delete();
        return redirect()->route('barangmasuk')->with('destroy', 'Data Berhasil Di Hapus');
    }
}
