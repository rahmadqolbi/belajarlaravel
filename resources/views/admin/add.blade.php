@extends('layouts.app')
@section('title', 'Tambah Data Kategori')
@section('content')

                    <form action="{{ route('kategori') }}" method="POST">
                        @csrf
                        @method('post')


                    <div class="mb-3">
                    <label for="" class="form-label">Kategori Barang</label>
                    <input
                        type="text"
                        class="form-control w-50 text-uppercase @error('nama_kategori') is-invalid @enderror"
                        name="nama_kategori"
                        id="nama_kategori"
                        aria-describedby="helpId"
                        placeholder="Masukkan Kategori"
                    autocomplete="off"/>
                    @error('nama_kategori')
                        {{-- <div class="alert alert-danger w-50">{{ $message }}</div> --}}
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                    <small id="helpId" class="form-text text-muted">Masukkan Kategori Dengan Benar</small>
                </div>
               <button type="submit" class="btn btn-primary">Tambah</button>

                    </form>

        @endsection
