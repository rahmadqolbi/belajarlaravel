@extends('layouts.app')
@section('title', 'Barang Masuk')
@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('destroy'))
<div class="alert alert-danger">{{ session('destroy') }}</div>

@endif


<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Supplier</th>
            <th>Tujuan</th>
            <th>No. Dokumen</th>
            <th>Keterangan</th>
            <th colspan="3">Aksi</th>
    </thead>
    <tbody>
            @foreach ($data as $list)

        <tr>
            <td>{{ $data->firstItem() + $loop->index }}</td>
           <td>{{ $list->tanggal->timezone('Asia/Jakarta')->format('d-M-Y') }}</td>
            <td>{{ $list->supplier->nama_supplier }}</td>
             <td>{{ $list->tujuan->nama_gudang ?? $list->tujuan->nama_outlet }}</td>
            <td>{{ $list->no_dokumen }}</td>
            <td>{{ $list->keterangan }}</td>
            <td>
                <a href="" class="btn btn-sm btn-info">Show</a>
                <a href="{{ route('barangmasuk.update', $list->id) }}" class="btn btn-sm btn-primary">Edit</a>
                <form action="{{ route('barangmasuk.destroy', $list->id) }}" method="POST" class="d-inline" onsubmit="return(confirm('Yakin Ingin Hapus Data ?'))">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
            @endforeach

    </tbody>
</table>
<a href="{{ route('barangmasuk.add') }}" class="btn btn-primary mb-3">Tambah</a>
<div class="d-flex justify-content-end">
{{ $data->links() }}

</div>

@endsection
