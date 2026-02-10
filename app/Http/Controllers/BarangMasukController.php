<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBarangMasukRequest;
use App\Http\Requests\UpdateBarangMasukRequest;
use App\Models\BarangMasuk;
use App\Models\Gudang;
use App\Models\Outlet;
use App\Models\Supplier;
use Illuminate\Http\Request;

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
        $noDokumen = 'BM-'.str_pad($urut, 4, '0', STR_PAD_LEFT);
        return view('barangmasuk.add', compact('data', 'gudangs', 'outlets', 'noDokumen'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBarangMasukRequest $request)
    {
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

            $barangMasuk->tujuan()->associate($tujuan);
            $barangMasuk->save();
    return redirect()->route('barangmasuk')->with('success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
{
     return view('barangmasuk.update', [
        'data'     => BarangMasuk::findOrFail($id),
        'supplier' => Supplier::all(),
        'gudangs'  => Gudang::all(),
        'outlets'  => Outlet::all(),
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
    // Ambil data lama
    $data = BarangMasuk::findOrFail($id);

    // Ambil dan tentukan tujuan
    [$type, $tujuanId] = explode('-', $request->tujuan_type);
    $type = strtolower($type);
    $tujuan = match($type) {
        'gudang' => Gudang::findOrFail($tujuanId),
        'outlet' => Outlet::findOrFail($tujuanId)
    };

    // Update data
    $data->tanggal     = $request->tanggal;
    $data->supplier_id = $request->supplier_id;
    $data->no_dokumen  = $request->no_dokumen;
    $data->keterangan  = $request->keterangan;

    // Update relasi
    $data->tujuan()->associate($tujuan);

    // Simpan perubahan
    $data->save();

    return redirect()->route('barangmasuk')->with('success', 'Data Berhasil Di Edit');
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
