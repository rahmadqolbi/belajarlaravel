@extends('layouts.app')
@section('title', 'Tambah Data Supplier')
@section('content')
                    <form action="{{ route('supplier') }}" method="POST">
                        @csrf
                        @method('POST')
                    <!-- Page Heading -->
                    {{-- <h1 class="h3 mb-4 text-gray-800">Blank Page</h1> --}}
                       <div class="mb-3">
                    <label for="nama_supplier" class="form-label">Supplier</label>
                    <input
                        type="text"
                        class="form-control w-50 text-uppercase @error('nama_supplier') is-invalid @enderror" id="nama_supplier""
                        name="nama_supplier"
                        id="nama_supplier"
                        aria-describedby="helpId"
                        placeholder="Masukkan Supplier"
                    autocomplete="off"/>
                     @error('nama_supplier')
                        {{-- <div class="alert alert-danger w-50">{{ $message }}</div> --}}
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                        {{-- <div class="alert alert-danger w-50">{{ $message }}</div> --}}
                    <small id="helpId" class="form-text text-muted">Wajib Di isi</small>
                </div>

                    <div class="mb-3">
                    <label for="no_hp" class="form-label">No Hp</label>
                    <input
                        type="number"
                        class="form-control w-50 text-uppercase"
                        name="no_hp"
                        id="no_hp"
                        aria-describedby="helpId"
                        placeholder="Masukkan No Hp"
                    autocomplete="off"/>
                    {{-- <small id="helpId" class="form-text text-muted">Wajib Di isi</small> --}}
                        {{-- <div class="alert alert-danger w-50">{{ $message }}</div> --}}
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input
                        type="text"
                        class="form-control w-50 text-uppercase"
                        name="alamat"
                        id="alamat"
                        aria-describedby="helpId"
                        placeholder="Masukkan Alamat"
                    autocomplete="off"/>
                    {{-- <small id="helpId" class="form-text text-muted">Wajib Di isi</small> --}}
                        {{-- <div class="alert alert-danger w-50">{{ $message }}</div> --}}
                    <button type="submit" class="btn btn-primary mt-3">Tambah</button>
                </div>
                </form>
                <!-- /.container-fluid -->
@endsection
