<?php

namespace App\Http\Controllers\Aktifitas;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequest;
use Illuminate\Http\Request;
use App\Models\Aktifitas;
use App\Models\Todo;

class AktifitasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $max_data = 5;
        if(request('search')){
            $data = Aktifitas::where('aktifitas', 'LIKE', '%'.request('search').'%')->paginate($max_data);
            dd($data);
        }else{
        }
        $data = Aktifitas::latest()->paginate($max_data);
        return view('aktifitas.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('aktifitas.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {

        // $request->validate([
        //     'nama' => 'required',
        //     'alamat' => 'required',
        //     'agama' => 'required',
        //     'nohp'   => 'required|numeric|min:12'
        // ],[
        //     'required' => ':attribute Wajib Di isi',
        //     'numeric' => ':attribute harus berupa angka',
        //     'min' => ':attribute minimal :min digit'
        // ]);
        $data = [
            'nama' => $request->input('nama'),
            'alamat' => $request->input('alamat'),
            'agama' => $request->input('agama'),
            'nohp' => $request->input('nohp')
        ];
        Aktifitas::create($data);
        // return view('aktifitas.add');
        return redirect()->route('aktifitas')->with('success', 'Data Berhasil Ditambah');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
      $data = Aktifitas::findOrFail($id);
      return view('aktifitas.update', compact('data'));
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
        // dd($request);
         $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'agama' => 'required',
            'nohp'   => 'required|numeric|min:12'
        ],[
            'required' => ':attribute Wajib Di isi',
            'numeric' => ':attribute harus berupa angka',
            'min' => ':attribute minimal :min digit'
        ]);
        $data = [
            'nama' => $request->input('nama'),
            'alamat' => $request->input('alamat'),
            'agama' => $request->input('agama'),
            'nohp' => $request->input('nohp')
        ];
        Aktifitas::where('id', $id)->update($data);
        // return view('aktifitas.add');
        return redirect()->route('aktifitas', ['page' =>$request->page])->with('success', 'Data Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Aktifitas::where('id', $id)->delete();
        return redirect()->route('aktifitas')->with('destroy', 'Data berhasil di hapus');

    }
}
