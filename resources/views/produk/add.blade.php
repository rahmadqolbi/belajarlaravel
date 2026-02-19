@extends('layouts.app')
@section('title', 'Data Produk')
@section('content')
                <div class="container-fluid">
                    <form action="{{ route('produk') }}" method="POST">
                        @csrf
                        @method('post')
                    <div class="col-md-4">
                        <label for="kode" class="form-label">Kode Barang</label>
                        <input type="text" class="form-control text-uppercase @error('kode') is-invalid @enderror" id="kode"     value="{{ $nextkode }}"
    readonly
 name="kode"  />
                        <small class="text-muted">Wajib Diisi</small>
                          @error('kode')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                    </div>
                    {{-- <div class="col-md-4 mt-3"> --}}
                    {{-- <div class="mt-3 ">
                    <label for="kategori" class="form-label ">Kategori</label>
                    <select
                        class="form-control text-uppercase form-control text-uppercase-lg w-100" name="kategori" id="kategori"
                >
                        <option selected value="">-</option>
                        <option value="">Lemari</option>
                        <option value="">Meja</option>
                    </select>
            </div> --}}

                    {{-- </div> --}}

                    <div class="col-md-4">
            <label for="kode" class="form-label">Kategori</label>
            <select class="custom-select @error('kategori_id') is-invalid @enderror" name="kategori_id">
                 <option value="">-- Pilih Kategori --</option>

                 @foreach ($data as $item)
        <option value="{{ $item->id }}"
            {{ old('kategori_id') == $item->id ? 'selected' : '' }}>
            {{ $item->nama_kategori }}
        </option>
    @endforeach
            </select>

               @error('kategori_id')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                    </div>



                     <div class="col-md-4 mt-3">
                        <label for="nama_barang" class="form-label ">Nama Barang</label>
                        <input type="text" value="{{ old('nama_barang') }}" class="form-control text-uppercase @error('nama_barang') is-invalid @enderror" id="nama_barang"  name="nama_barang" />
                        <small class="text-muted">Wajib Diisi</small>
                              @error('nama_barang')
                        {{-- <div class="alert alert-danger w-50">{{ $message }}</div> --}}
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                    </div>

                      <div class="col-md-4 mt-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" class="form-control @error('harga') is-invalid @enderror " id="harga" value="{{ old('harga') }}" name="harga" />
                        <small class="text-muted">Wajib Diisi</small>
                         @error('harga')
                        {{-- <div class="alert alert-danger w-50">{{ $message }}</div> --}}
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                    </div>
            {{-- <div class="col-md-4 mt-3">
                        <label for="stok" class="form-label">Stok</label>
                        <input type="number" class="form-control" id="stok" value="" name="stok" placeholder="0" />
                    </div> --}}
                    <button type="submit" class="btn btn-primary mt-3 ml-2">Tambah</button>
                    </form>
@endsection
