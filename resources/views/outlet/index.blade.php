@extends('layouts.app')
@section('title', 'Data Outlet')
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
            <th>Kode</th>
            <th>Nama Outlet</th>
            <th>Alamat</th>
            <th>Penanggung Jawab</th>
            <th>Telepon</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $list)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $list->kode_outlet  }}</td>
            <td>{{ $list->nama_outlet  }}</td>
            <td>{{ $list->alamat }}</td>
            <td>{{ $list->penanggung_jawab }}</td>
            <td>{{ $list->telepon }}</td>
            <td>
                <span class="badge {{ $list->status == 'Aktif' ? 'badge-success' : 'badge-danger' }}">
                    {{ $list->status }}
                </span>
            </td>
            <td>
                <a href="{{ route('outlet.update', $list->id) }}" class="btn btn-sm btn-primary">Edit</a>
                <form action="{{ route('outlet.destroy', $list->id) }}" method="POST" onsubmit="return(confirm('Yakin Ingin Hapus Data ?'))" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach

    </tbody>
</table>
<a href="{{ route('outlet.add') }}" class="btn btn-primary mb-3">Tambah</a>




@endsection
