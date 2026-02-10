@extends('layouts.app')
@section('title', 'Data Supplier')
@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('destroy'))
<div class="alert alert-danger">{{ session('destroy') }}</div>

@endif
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                        <th style="width: 50px;">No</th>
                            <th>Nama Supplier</th>
                            <th>No Hp</th>
                            <th>Alamat</th>
                            <th>Created At</th>
                            <th colspan="2">Aksi</th>
                            </tr>

                        </thead>
                        <tbody>
                            @foreach ($data as $list)

                            <tr>
                                <td class="text-center">{{ $loop->iteration.'.' }}</td>
                                <td>{{ $list->nama_supplier }}</td>
                                <td>{{ $list->no_hp }}</td>
                                <td>{{ $list->alamat }}</td>
                               <td>   {{ $list->created_at->timezone('Asia/Jakarta')->translatedFormat('d F Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('supplier.update', $list->id) }}" class="btn btn-sm btn-primary" >Edit</a>
                                    <form action="{{ route('supplier.destroy', $list->id) }}" class="d-inline" onsubmit="return(confirm('Yakin Ingin Hapus Data'))" method="POST">
                                        @csrf
                                        @method('DELETE')
                                     <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                      </form>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>

                    <a href="{{ route('supplier.add') }}" class="btn btn-primary">Tambah</a>
               @endsection
