@extends('layouts.app')
@section('title', 'Edit Data Kategori')
@section('content')

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    {{-- <h1 class="h3 mb-4 text-gray-800">Blank Page</h1> --}}

                    <form action="{{ route('kategori.update', $data->id) }}" method="POST">
                        @csrf
                        @method('put')


                    <div class="mb-3">
                    <label for="nama_kategori" class="form-label">Kategori Barang</label>
                    <input
                        type="text"
                        class="form-control w-50 text-uppercase @error('nama_kategori') is-invalid @enderror"
                        name="nama_kategori"
                        id="nama_kategori"
                        aria-describedby="helpId"
                        placeholder="Masukkan Kategori"
                    autocomplete="off"/ value="{{ old('nama_kategori', $data->nama_kategori) }}">
                    @error('nama_kategori')
                        {{-- <div class="alert alert-danger w-50">{{ $message }}</div> --}}
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                    <small id="helpId" class="form-text text-muted">Masukkan Kategori Dengan Benar</small>
                </div>
               <button type="submit" class="btn btn-primary">Edit</button>
                    </form>
                </div>
 @endsection
