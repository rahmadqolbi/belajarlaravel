@extends('layouts.app')
@section('title', 'Edit Data Outlet')
@section('content')
 <form action="{{ route('outlet.update', $data->id) }}" method="POST">
                        @csrf
                        @method('put')
                   <div class="row">
    <!-- KOLOM KIRI -->
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">Kode outlet</label>
            <input type="text" class="form-control text-uppercase @error('kode_outlet') is-invalid @enderror" name="kode_outlet" value="{{ $data->kode_outlet }}" >
             @error('kode_outlet')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Nama outlet</label>
            <input type="text" class="form-control text-uppercase @error('nama_outlet') is-invalid @enderror" name="nama_outlet" value="{{ $data->nama_outlet }}"/>
               @error('nama_outlet')
                        {{-- <div class="alert alert-danger w-50">{{ $message }}</div> --}}
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat outlet</label>
            <input type="text" class="form-control text-uppercase @error('alamat') is-invalid @enderror" name="alamat" value="{{ $data->alamat }}">
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
            <input type="text" class="form-control text-uppercase @error('penanggung_jawab') is-invalid @enderror" name="penanggung_jawab" value="{{ $data->penanggung_jawab }}">
              @error('penanggung_jawab')
                        {{-- <div class="alert alert-danger w-50">{{ $message }}</div> --}}
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
        </div>

        <div class="mb-3">
            <label class="form-label ">Telepon</label>
            <input type="text" class="form-control text-uppercase @error('telepon') is-invalid @enderror" name="telepon" value="{{ $data->telepon }}">
               @error('telepon')
                        {{-- <div class="alert alert-danger w-50">{{ $message }}</div> --}}
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
        </div>

      <div class="mb-3">
       <label class="form-label">Status</label>
<select class="custom-select " name="status">
    <option value="">-- Pilih Status --</option>

    <option value="Aktif"
        {{ old('status', $data->status) == 'Aktif' ? 'selected' : '' }}>
        Aktif
    </option>

    <option value="Non Aktif"
        {{ old('status', $data->status) == 'Non Aktif' ? 'selected' : '' }}>
        Non Aktif
    </option>
</select>

        </div>
            </div>
        </div>
            <button class="btn btn-primary" type="submit">Edit</button>
                <!-- /.container-fluid -->
                    </form>
@endsection
