@extends('layouts.app')
@section('title', 'Data Produk')
@section('content')
                <div class="container-fluid">
                    <form action="{{ route('produk.update', $data->id) }}" method="POST">
                        @csrf
                        @method('put')
                    <div class="col-md-4">

                        <label for="kode" class="form-label">Kode Barang</label>
                        <input type="text" class="form-control text-uppercase @error('kode') is-invalid @enderror" id="kode" value="{{ $data->kode }}" name="kode"   readonly/>
                        <small class="text-muted">Wajib Diisi</small>
                          @error('kode')
                        {{-- <div class="alert alert-danger w-50">{{ $message }}</div> --}}
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                    </div>



       <div class="col-md-4 mt-3">
<label for="kode" class="form-label">Kategori</label>
<select
    name="kategori_id"
    class="custom-select @error('kategori_id') is-invalid @enderror"
>
    <option value="">-- Pilih Kategori --</option>

    @foreach ($data_kategori as $item)
        <option value="{{ $item->id }}"
            {{ old('kategori_id', $data->kategori_id) == $item->id ? 'selected' : '' }}>
            {{ $item->nama_kategori }}
        </option>
    @endforeach
</select>
@error('kategori_id')
<div class="text-danger mt-1">{{ $message }}</div>
@enderror
</div>

@error('kategori_id')
    <div class="invalid-feedback">{{ $message }}</div>
@enderror


@error('kategori_id')
    <div class="invalid-feedback">{{ $message }}</div>
@enderror




                     <div class="col-md-4 mt-3">
                        <label for="nama_barang" class="form-label ">Nama Barang</label>
                        <input type="text" value="{{ $data->nama_barang}}" class="form-control text-uppercase @error('nama_barang') is-invalid @enderror" id="nama_barang"  name="nama_barang" />
                        <small class="text-muted">Wajib Diisi</small>
                              @error('nama_barang')
                        {{-- <div class="alert alert-danger w-50">{{ $message }}</div> --}}
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                    </div>

                      <div class="col-md-4 mt-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga" value="{{ $data->harga }}" name="harga"  />
                        <small class="text-muted">Wajib Diisi</small>
                         @error('harga')
                        {{-- <div class="alert alert-danger w-50">{{ $message }}</div> --}}
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                    </div>
   {{-- <div class="col-md-4 mt-3">
                        <label for="stok" class="form-label">Stok</label>
                        <input type="number" class="form-control" id="stok" value="{{ $data->stok }}" name="stok" />
                    </div> --}}
                    <button type="submit" class="btn btn-primary mt-3 ml-2">Edit</button>
                    </form>
@endsection
