@extends('layouts.app')
@section('title', 'Tambah Barang Masuk')

@section('content')
 <form action="{{ route('barangmasuk') }}" method="POST">
                        @csrf
                        @method('post')
                   <div class="row">
    <!-- KOLOM KIRI -->
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">Tanggal</label>
            <input type="date" class="form-control text-uppercase @error('tanggal') is-invalid @enderror" name="tanggal" value="{{ old('tanggal') }}">
              @error('tanggal')
                        {{-- <div class="alert alert-danger w-50">{{ $message }}</div> --}}
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
        </div>

      <div class="mb-3">
            <label for="supplier" class="form-label">Supplier</label>
            <select class="custom-select @error('supplier_id') is-invalid @enderror" name="supplier_id">
                 <option value="">-- Pilih Kategori --</option>

                 @foreach ($data as $item)
        <option value="{{ $item->id }}"
            {{ old('supplier_id') == $item->id ? 'selected' : '' }}>
            {{ $item->nama_supplier }}
        </option>
    @endforeach
            </select>

               @error('supplier_id')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                    </div>

        <div class="mb-3">
            <label for="tujuan" class="form-label">Tujuan</label>
            <select class="custom-select @error('tujuan_type') is-invalid @enderror" name="tujuan_type">
                 <option value="">-- Pilih Kategori --</option>

                  <optgroup label="Gudang">
        @foreach ($gudangs as $gudang)
            <option value="gudang-{{ $gudang->id }}">
                {{ $gudang->nama_gudang }}
            </option>
        @endforeach
                </optgroup>
                <optgroup label="Outlet">
                    @foreach ($outlets as $outlet)
                        <option value="outlet-{{ $outlet->id }}">
                            {{ $outlet->nama_outlet }}
                        </option>
                    @endforeach
                </optgroup>
            </select>
               @error('tujuan_type')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                    </div>
    </div>

    <!-- KOLOM KANAN -->
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">No Dokumen</label>
            <input type="text" class="form-control text-uppercase @error('no_dokumen') is-invalid @enderror" name="no_dokumen" value="{{ $noDokumen }}" readonly>
              @error('no_dokumen')
                        {{-- <div class="alert alert-danger w-50">{{ $message }}</div> --}}
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
        </div>

        <div class="mb-3">
            <label class="form-label ">Keterangan</label>
            <input type="text" class="form-control text-uppercase @error('keterangan') is-invalid @enderror" name="keterangan" value="{{ old('keterangan') }}">
               @error('keterangan')
                        {{-- <div class="alert alert-danger w-50">{{ $message }}</div> --}}
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
        </div>

            </div>
        </div>
            <button class="btn btn-primary" type="submit">Tambah</button>


                <!-- /.container-fluid -->
                    </form>
@endsection
