<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Supplier::latest()->get();
        return view('supplier.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('supplier.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request)
    {
        $data = [
            'nama_supplier' => $request->input('nama_supplier'),
            'no_hp'         => $request->input('no_hp'),
            'alamat'        => $request->input('alamat'),
        ];
        Supplier::create($data);
        return redirect()->route('supplier')->with('success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Supplier::findOrFail($id);
        return view('supplier.update', compact('data'));
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
    public function update(UpdateSupplierRequest $request, string $id)
    {
       $data = [
            'nama_supplier' => $request->input('nama_supplier'),
            'no_hp'         => $request->input('no_hp'),
            'alamat'        => $request->input('alamat'),
        ];
        Supplier::where('id', $id)->update($data);
        return redirect()->route('supplier')->with('success', 'Data Berhasil Di Edit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Supplier::where('id', $id)->delete();
        return redirect()->route('supplier')->with('destroy', 'Data Berhasil Di Delete');
    }
}
