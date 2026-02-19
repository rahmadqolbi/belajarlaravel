@extends('layouts.app')
@section('title', 'Data Produk')
@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('destroy'))
<div class="alert alert-danger">{{ session('destroy') }}</div>
@endif
@if (session('qty'))
<div class="alert alert-danger">{{ sesstion('qty') }}</div>

@endif

    <div class="card shadow-sm mb-4">
        <div class="card-body">
             <table class="table table-hover width="100%" cellspacing="0"">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Harga</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>


                        @foreach ($data as $list)
                             <tr>
                            <td>{{ $data->firstItem() + $loop->index.'.' }}</td>
                            <td>{{ $list->kode }}</td>
                            <td>{{ $list->nama_barang }}</td>
                            <td> {{ $data_kategori[$list->kategori_id] ?? '-' }}</td>
                            <td>{{ $list->stok }}</td>
                            <td>{{ "Rp " . number_format($list->harga, 0, ',', '.') }}</td>
                            <td>   {{ $list->created_at->timezone('Asia/Jakarta')->translatedFormat('d F Y H:i') }}</td>
                            <td>
                                <a href="{{ route('produk.update', [$list->id]) }}" class="btn btn-sm btn-primary">Edit</a>

                                <form action="{{ route('produk.destroy', $list->id) }}" method="POST" class="d-inline" onsubmit="return(confirm('Yakin Ingin Hapus Data'))">
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

                <div class="d-flex justify-content-end">
                     {{ $data->appends(request()->query())->links() }}

                </div>
        </div>
    </div>

@endsection
