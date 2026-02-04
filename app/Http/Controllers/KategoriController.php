<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKategoriRequest;
use App\Http\Requests\UpdateKategoriRequest;
use App\Http\Requests\UpdateRequest;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Kategori::latest()->get();
        return view('admin.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKategoriRequest $request)
    {
        $data = [
             'nama_kategori' => $request->input('nama_kategori')

        ];
        // dd($data);
        Kategori::create($data);
        return redirect()->route('kategori')->with('success', 'Kategori Berhasil Ditambahkan');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Kategori::findOrFail($id);
        return view('admin.update', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKategoriRequest $request, string $id)
    {
        //
        $data = [
            'nama_kategori' => $request->input('nama_kategori')
        ];
        // dd($data);
        Kategori::where('id', $id)->update($data);
        return redirect()->route('kategori')->with('success', 'Data Berhasil Di Edit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
        Kategori::where('id', $id)->delete();
        return redirect()->route('kategori')->with('destroy', 'Data Berhasil Dihapus');
        }
        catch(\Throwable $e){
            return redirect() ->route('kategori') ->with('error', 'Kategori tidak bisa dihapus karena masih digunakan oleh produk');
        }

    }
}
