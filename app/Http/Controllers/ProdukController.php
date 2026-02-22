<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProdukRequest;
use App\Http\Requests\UpdateProdukRequest;
use App\Models\Kategori;
use App\Models\ProdukModel;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $max = 5;

        if(request('search')){
        $data = ProdukModel::where('nama_barang', 'LIKE', '%'.request('search').'%')->latest()->paginate($max);
        }else{
        $data = ProdukModel::latest()->paginate($max);

        }
        $data_kategori = Kategori::pluck('nama_kategori', 'id');
        return view('produk.index', compact('data', 'data_kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = Kategori::all();
         $lastKode = ProdukModel::max('kode');

        $nextkode = $lastKode
        ? 'BRGFNXA' . str_pad((int) substr($lastKode, -2) + 1, 2, '0', STR_PAD_LEFT)
        : 'BRGFNXA01';

        return view('produk.add',compact('data', 'nextkode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProdukRequest $request)
    {

    //  $lastKode = ProdukModel::max('kode');

        // $nextKode = $lastKode
        // ? 'AAA' . str_pad((int)substr($lastKode, -2) + 1, 2, '0', STR_PAD_LEFT)
        // : 'AAA01';
        $data = [
            'kategori_id' => $request->input('kategori_id'),
            // 'kode' => $nextKode,
            'kode' => $request->input('kode'),
            'nama_barang' => $request->input('nama_barang'),
            'stok' => $request->stok ?? 0,
            'harga' => $request->input('harga'),
        ];

        ProdukModel::create($data);
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
           'stok' => $request->stok ?? 0,
            'harga' => $request->input('harga'),
        ];
        ProdukModel::where('id', $id)->update($data);
        return redirect()->route('produk')->with('success', 'Data Berhasil Di Edit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        ProdukModel::where('id', $id)->delete();
        return redirect()->route('produk')->with('delete', 'Data Berhasil Di Hapus');
    }
}
