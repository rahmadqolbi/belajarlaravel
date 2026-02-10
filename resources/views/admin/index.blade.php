@extends('layouts.app')
@section('title', 'Data Kategori')
@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('destroy'))
<div class="alert alert-danger">{{ session('destroy') }}</div>
@endif
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <th style="width: 50px;">No</th>
                            <th>Kategori Barang</th>
                            <th>Aksi</th>
                        </thead>
                        <tbody>
                            @foreach ($data as $list)
                        <tr>
                                <td class="text-center">{{ $loop->iteration.'.' }}</td>
                                <td>{{ $list->nama_kategori }}</td>
                                <td>
                                    <a href="{{ route('kategori.update', ['id' => $list->id]) }}" class="btn btn-primary">Edit</a>

                                    <form action="{{ route('kategori.destroy', ['id' =>$list->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin Ingin Menghapus Data ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger d-inline">Delete</button>
                                    </form>



                                </td>


                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                <a href="{{ route('kategori.add') }}" class="btn btn-primary">Tambah</a>
@endsection
