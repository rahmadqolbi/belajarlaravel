<?php

namespace App\Http\Controllers\Halo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HaloController extends Controller
{
    //
    public function index(){
    //    $nama = 'Qolbi';
    //    $data = ['aa' => $nama];
       return view('admin.index');
    }
}
