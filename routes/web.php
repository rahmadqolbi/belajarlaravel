<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Aktifitas\AktifitasController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangMasukDetailController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\Halo\HaloController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\Todo\TodoController;
// use App\Models\Supplier;


Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
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

Route::get('/outlet', [OutletController::class, 'index'])->name('outlet');
Route::get('/outlet/add', [OutletController::class, 'create'])->name('outlet.add');
Route::post('/outlet', [OutletController::class, 'store'])->name('outlet.post');
Route::get('/outlet/{id}', [OutletController::class, 'show'])->name('outlet.update');
Route::put('/outlet/{id}', [OutletController::class, 'update'])->name('outlet.update');
Route::delete('/outlet/{id}', [OutletController::class, 'destroy'])->name('outlet.destroy');

Route::get('/barangmasuk', [BarangMasukController::class, 'index'])->name('barangmasuk');
Route::get('/barangmasuk/add', [BarangMasukController::class, 'create'])->name('barangmasuk.add');
Route::post('/barangmasuk', [BarangMasukController::class, 'store'])->name('barangmasuk.post');
Route::get('/barangmasuk/{id}', [BarangMasukController::class, 'show'])->name('barangmasuk.update');
Route::put('/barangmasuk/{id}', [BarangMasukController::class, 'update'])->name('barangmasuk.update');
Route::delete('/barangmasuk/{id}', [BarangMasukController::class, 'destroy'])->name('barangmasuk.destroy');
});
Route::get('/barangmasukdetail', [BarangMasukDetailController::class, 'index'])->name('barangmasukdetail');


Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan');
Route::get('/penjualan/add', [PenjualanController::class, 'create'])->name('penjualan.add');
Route::post('/penjualan', [PenjualanController::class, 'store'])->name('penjualan.add');
Route::get('/penjualan/{id}', [PenjualanController::class, 'show'])->name('penjualan.update');
Route::put('/penjualan/{id}', [PenjualanController::class, 'update'])->name('penjualan.update');
Route::post('/penjualan/{id}', [PenjualanController::class, 'cancel'])->name('penjualan.cancel');
require __DIR__.'/auth.php';



