<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGudangRequest;
use App\Models\Gudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\UpdateGudangRequest;


class GudangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Gudang::latest()->get();
        return view('gudang.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{

    return view('gudang.add');
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGudangRequest $request)
    {
        $data = ([
            'kode_gudang' => $request->input('kode_gudang'),
            'nama_gudang' => $request->input('nama_gudang'),
            'alamat' => $request->input('alamat'),
            'penanggung_jawab' => $request->input('penanggung_jawab'),
            'telepon' => $request->input('telepon'),
            'status' => $request->input('status'),
        ]);


        Gudang::create($data);
        return redirect()->route('gudang')->with('success', 'Data Berhasil Di Tambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Gudang::findOrFail($id);
        return view('gudang.update', compact('data'));
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
    public function update(UpdateGudangRequest $request, string $id)
    {
        $data = ([
            'kode_gudang' => $request->input('kode_gudang'),
            'nama_gudang' => $request->input('nama_gudang'),
            'alamat' => $request->input('alamat'),
            'penanggung_jawab' => $request->input('penanggung_jawab'),
            'telepon' => $request->input('telepon'),
            'status' => $request->input('status'),
        ]);
        Gudang::where('id', $id)->update($data);
        return redirect()->route('gudang')->with('success', 'Data Berhasil Di Edit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gudang::where('id', $id)->delete();
        return redirect()->route('gudang')->with('destroy', 'Data Berhasil DiHapus');
    }
}
