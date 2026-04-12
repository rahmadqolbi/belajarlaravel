<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProdukRequest;
use App\Http\Requests\UpdateProdukRequest;
use App\Models\Kategori;
use App\Models\Outlet;
use App\Models\ProdukModel;
use App\Models\StokOutlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $outlet = Outlet::all();
        $search = $request->input('search');
        $data = ProdukModel::with('produk')
        ->when($search, function($query, $search){
            $query->where('nama_barang', 'like', "%{$search}%");
        })

        ->latest()->paginate(5);
        // dd($search);
        $max = 5;
       $stokGlobal = StokOutlet::select('produk_id', DB::raw('SUM(stok) as total_stok'))
            ->groupBy('produk_id')
            ->pluck('total_stok', 'produk_id');

    $data_kategori = Kategori::pluck('nama_kategori', 'id');
        return view('produk.index', compact('data', 'data_kategori', 'search', 'outlet', 'stokGlobal'));

        // if(request('search')){
        // $data = ProdukModel::where('nama_barang', 'LIKE', '%'.request('search').'%')->latest()->paginate($max);
        // }else{
        // $data = ProdukModel::latest()->paginate($max);

        // }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $data = Kategori::all();
    $outlets = Outlet::all(); // ← tambahkan ini

    $lastKode = ProdukModel::max('kode');
    $nextkode = $lastKode
        ? 'BRGFNXA' . str_pad((int) substr($lastKode, -2) + 1, 2, '0', STR_PAD_LEFT)
        : 'BRGFNXA01';

    return view('produk.add', compact('data', 'nextkode', 'outlets')); // ← tambah 'outlets'
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProdukRequest $request)
{
    $produk = ProdukModel::create([
        'kategori_id' => $request->input('kategori_id'),
        'kode'        => $request->input('kode'),
        'nama_barang' => $request->input('nama_barang'),
        'harga'       => $request->input('harga'),
        'harga_modal'       => $request->input('harga_modal'),
    ]);

    // Simpan stok awal ke stok_outlet jika ada
    if ($request->stok && $request->outlet_id) {
        StokOutlet::create([
            'produk_id' => $produk->id,
            'outlet_id' => $request->outlet_id,
            'stok'      => $request->stok,
        ]);
    }

    return redirect()->route('produk')->with('success', 'Produk Berhasil Ditambahkan');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
     $data   = ProdukModel::findOrFail($id);
    $data_kategori = Kategori::all();
        // dd($data);
        return view('produk.update', compact('data', 'data_kategori'));
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
    public function update(UpdateProdukRequest $request, string $id)
    {
        $data =[
               'kategori_id' => $request->input('kategori_id'),
            'kode' => $request->input('kode'),
            'nama_barang' => $request->input('nama_barang'),
            'harga' => $request->input('harga'),
            'harga_modal' => $request->input('harga_modal'),
        ];
        ProdukModel::where('id', $id)->update($data);
        return redirect()->route('produk')->with('success', 'Data Berhasil Di Edit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produk = ProdukModel::findOrFail($id);
        $totalStok = StokOutlet::where('produk_id', $id)->sum('stok');
        if($totalStok > 0){
             return redirect()->route('produk')
            ->with('error', 'Produk tidak bisa dihapus! Masih ada stok ' . $totalStok . ' di outlet.');
        }
        $produk->delete();
        return redirect()->route('produk')->with('delete', 'Data Berhasil Di Hapus');
    }

    public function stokCabang(string $id)
{
    $produk = ProdukModel::findOrFail($id);

    $stokPerOutlet = DB::table('stok_outlet')
        ->join('outlet', 'outlet.id', '=', 'stok_outlet.outlet_id')
        ->where('stok_outlet.produk_id', $id)
        ->select('outlet.nama_outlet', 'stok_outlet.stok', 'stok_outlet.updated_at')
        ->get();

    $totalStok = $stokPerOutlet->sum('stok');

    return view('produk.stok-cabang', compact('produk', 'stokPerOutlet', 'totalStok'));
}
}
