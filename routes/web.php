<?php

use App\Http\Controllers\Aktifitas\AktifitasController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\Halo\HaloController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\Todo\TodoController;
use App\Models\Supplier;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\HomeController;
// Route::get('a/', function () {
//     return view('welcome');
// });


// Route::get('/', function(){
//     return view('user.index');
// });
// Route::get('/',[HomeController::class, 'index']);
// Route::get('/halo', function(){
//     return view('coba.halo');
// });
Route::get('/halo', [HaloController::class, 'index']);
Route::get('/todo', [TodoController::class, 'index'])->name('todo');
Route::post('/todo', [TodoController::class, 'store'])->name('todo.post');
Route::put('/todo/{id}', [TodoController::class, 'update'])->name('todo.update');
Route::delete('/todo/{id}', [TodoController::class, 'destroy'])->name('todo.delete');

// tampilkan data
Route::get('/aktifitas', [AktifitasController::class, 'index'])->name('aktifitas');

// tampilkan form
Route::get('/aktifitas/add', [AktifitasController::class, 'create'])->name('aktifitas.add');

// simpan data
Route::post('/aktifitas', [AktifitasController::class, 'store'])->name('aktifitas.post');

// edit data
Route::get('/aktifitas/{id}', [AktifitasController::class, 'show'])->name('aktifitas.update');

// proses edit data
Route::put('/aktifitas/{id}', [AktifitasController::class, 'update'])->name('aktifitas.update');

// delete data
Route::delete('/aktifitas/{id}', [AktifitasController::class, 'destroy'])->name('aktifitas.destroy');




//menu kategori
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori');
//menu add kategori
Route::get('/kategori/add', [KategoriController::class, 'create'])->name('kategori.add');
//proses tambah data
Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.post');
//Tampil Data
Route::get('/kategori/{id}', [KategoriController::class, 'show'])->name('kategori.update');
//Proses Edit
Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
//Proses Delete
Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');


Route::get('/produk', [ProdukController::class, 'index'])->name('produk');
Route::get('/produk/add', [ProdukController::class, 'create'])->name('produk.add');
Route::post('/produk', [ProdukController::class, 'store'])->name('produk.post');
Route::get('/produk/{id}', [ProdukController::class,'show'])->name('produk.update');
Route::put('/produk/{id}', [ProdukController::class,'update'])->name('produk.update');
Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');

Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier');
Route::get('/supplier/add', [SupplierController::class, 'create'])->name('supplier.add');
Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.post');
Route::get('/supplier/{id}', [SupplierController::class, 'show'])->name('supplier.update');
Route::put('/supplier/{id}', [SupplierController::class, 'update'])->name('supplier.update');
Route::delete('/supplier/{id}', [SupplierController::class, 'destroy'])->name('supplier.destroy');

Route::get('/gudang', [GudangController::class, 'index'])->name('gudang');
Route::get('/gudang/add', [GudangController::class, 'create'])->name('gudang.add');
Route::post('/gudang', [GudangController::class, 'store'])->name('gudang.post');
Route::get('/gudang/{id}', [GudangController::class, 'show'])->name('gudang.update');
Route::put('/gudang/{id}', [GudangController::class, 'update'])->name('gudang.update');
Route::delete('/gudang/{id}', [GudangController::class, 'destroy'])->name('gudang.destroy');
