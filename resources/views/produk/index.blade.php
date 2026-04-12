@extends('layouts.app')
@section('title', 'Data Produk')
@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('destroy'))
    <div class="alert alert-danger">{{ session('destroy') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card shadow-sm mb-4">
    <div class="card-body">

        {{-- Search --}}
        <form action="{{ route('produk') }}" method="GET" class="row mb-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control"
                    placeholder="Cari nama barang..."
                    value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100">Cari</button>
            </div>
        </form>

        {{-- Tabel --}}
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Stok (Semua Outlet)</th>
                    <th>Harga Modal</th>
                    <th>Harga</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $list)
                    @php
                        $stok = $stokGlobal[$list->id] ?? 0;
                        $badgeClass = $stok > 0 ? 'success' : ($stok > 2 ? 'success' : 'danger');
                    @endphp
                    <tr>
                        <td>{{ $data->firstItem() + $loop->index . '.' }}</td>
                        <td>{{ $list->kode }}</td>
                        <td>{{ $list->nama_barang }}</td>
                        <td>{{ $data_kategori[$list->kategori_id] ?? '-' }}</td>
                        <td>
                            <span class="text-light badge bg-{{ $badgeClass }}">
                                {{ $stok }} pcs
                            </span>
                        </td>
                         <td>{{ 'Rp ' . number_format($list->harga_modal, 0, ',', '.') }}</td>
                        <td>{{ 'Rp ' . number_format($list->harga, 0, ',', '.') }}</td>
                        <td>{{ $list->created_at->timezone('Asia/Jakarta')->translatedFormat('d F Y H:i') }}</td>
                        <td>
                             <a href="{{ route('produk.stok', $list->id) }}"
                     class="btn btn-sm btn-info text-white">Detail</a>
                            <a href="{{ route('produk.update', $list->id) }}"
                               class="btn btn-sm btn-primary">Edit</a>

                            <form action="{{ route('produk.destroy', $list->id) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Yakin ingin hapus data?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('produk.add') }}" class="btn btn-primary">Tambah</a>

        <div class="d-flex justify-content-end mt-2">
            {{ $data->appends(['search' => $search])->links() }}
        </div>

    </div>
</div>

@endsection
