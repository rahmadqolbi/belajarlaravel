<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOutletRequest;
use App\Http\Requests\UpdateoutletRequest;
use App\Models\Outlet;
use Illuminate\Http\Request;

class OutletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Outlet::latest()->get();
        return view('outlet.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('outlet.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOutletRequest $request)
    {
       $data = ([
            'kode_outlet' => $request->input('kode_outlet'),
            'nama_outlet' => $request->input('nama_outlet'),
            'alamat' => $request->input('alamat'),
            'penanggung_jawab' => $request->input('penanggung_jawab'),
            'telepon' => $request->input('telepon'),
            'status' => $request->input('status'),
        ]);

        Outlet::create($data);
        return redirect()->route('outlet')->with('success', 'Data Berhasil Di Tambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Outlet::findOrFail($id);
        return view('outlet.update', compact('data'));
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
    public function update(UpdateoutletRequest $request, string $id)
    {
           $data = ([
            'kode_outlet' => $request->input('kode_outlet'),
            'nama_outlet' => $request->input('nama_outlet'),
            'alamat' => $request->input('alamat'),
            'penanggung_jawab' => $request->input('penanggung_jawab'),
            'telepon' => $request->input('telepon'),
            'status' => $request->input('status'),
        ]);
        Outlet::where('id', $id)->update($data);
        return redirect()->route('outlet')->with('success', 'Data Berhasil Di Edit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Outlet::where('id', $id)->delete();
        return redirect()->route('outlet')->with('destroy', 'Data Berhasil Di Hapus');
    }
}
