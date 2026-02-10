@extends('layouts.app')

@section('title', 'Tambah Outlet')
@section('content')
                    <form action="{{ route('outlet') }}" method="POST">
                        @csrf
                        @method('post')
                   <div class="row">
    <!-- KOLOM KIRI -->
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">Kode outlet</label>
            <input type="text" class="form-control text-uppercase @error('kode_outlet') is-invalid @enderror" name="kode_outlet" value="{{ old('kode_outlet') }}">
              @error('kode_outlet')
                        {{-- <div class="alert alert-danger w-50">{{ $message }}</div> --}}
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Nama outlet</label>
            <input type="text" class="form-control text-uppercase @error('nama_outlet') is-invalid @enderror" name="nama_outlet" value="{{ old('nama_outlet') }}">
               @error('nama_outlet')
                        {{-- <div class="alert alert-danger w-50">{{ $message }}</div> --}}
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat outlet</label>
            <input type="text" class="form-control text-uppercase @error('alamat') is-invalid @enderror" name="alamat" value="{{ old('alamat') }}">
              @error('alamat')
                        {{-- <div class="alert alert-danger w-50">{{ $message }}</div> --}}
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
        </div>
    </div>

    <!-- KOLOM KANAN -->
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">Penanggung Jawab</label>
            <input type="text" class="form-control text-uppercase @error('penanggung_jawab') is-invalid @enderror" name="penanggung_jawab" value="{{ old('penanggung_jawab') }}">
              @error('penanggung_jawab')
                        {{-- <div class="alert alert-danger w-50">{{ $message }}</div> --}}
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
        </div>

        <div class="mb-3">
            <label class="form-label ">Telepon</label>
            <input type="number" class="form-control text-uppercase @error('telepon') is-invalid @enderror" name="telepon" value="{{ old('telepon') }}">
               @error('telepon')
                        {{-- <div class="alert alert-danger w-50">{{ $message }}</div> --}}
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
        </div>

      <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select class="custom-select " name="status"> <option value="-">-- Pilih Kategori --</option>
            <option value="Aktif">Aktif</option>
            <option value="Non Aktif">Non Aktif</option>

    </select>
        </div>
            </div>
        </div>
            <button class="btn btn-primary" type="submit">Tambah</button>


                <!-- /.container-fluid -->
                    </form>
  @endsection
