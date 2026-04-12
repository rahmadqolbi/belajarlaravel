<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AkunPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $outlet = Outlet::all();
        return view('akunpenjualan.index', compact('outlet'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

     $cekUser = User::count();

    if ($cekUser >= 2) {
        return redirect()->back()->with('error', 'Anda hanya diperbolehkan memiliki 1 akun penjualan. Silakan hubungi developer untuk menambahkan akun baru.');
    }
        $data = [
            'name' => $request->input('name'),
            'email'=> $request->input('email'),
            'password' => Hash::make($request->password),
            'outlet_id' => $request->input('outlet_id')

        ];
        User::create($data);
        return redirect()->route('akunpenjualan')->with('success', 'Pendaftaran Akun Berhasil Ditambahkan');
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
