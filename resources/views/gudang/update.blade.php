@extends('layouts.app')

@section('title', 'Edit Data Gudang')
@section('content')
                    <form action="{{ route('gudang.update', $data->id) }}" method="POST">
                        @csrf
                        @method('put')
                   <div class="row">
    <!-- KOLOM KIRI -->
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">Kode Gudang</label>
            <input type="text" class="form-control text-uppercase" name="kode_gudang" value="{{ $data->kode_gudang }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Gudang</label>
            <input type="text" class="form-control text-uppercase @error('nama_gudang') is-invalid @enderror" name="nama_gudang" value="{{ $data->nama_gudang }}"/>
               @error('nama_gudang')
                        {{-- <div class="alert alert-danger w-50">{{ $message }}</div> --}}
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat Gudang</label>
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
                        </div>
                    </form>
            </div>
@endsection
