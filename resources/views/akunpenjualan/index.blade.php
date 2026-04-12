@extends('layouts.app');
@section('title', 'Kelola Akun Penjualan');
@section('content')
@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<div class="container-fluid">
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Kelola Akun Penjualan</h5>
        </div>
        <form action="{{route('akunpenjualan')}}" method="POST">
            @csrf
            @method('POST')
   <div class="card-body">
            <div class="row-mb-4">
                <div class="col-md-12 mb-3">
                  <label for="">Nama</label>
                 <input type="text" class="form-control w-50" name="name">
            </div>
            <div class="row-mb-4">
                <div class="col-md-12 mb-3">
                  <label for="">Email</label>
                 <input type="text" class="form-control w-50" name="email">
            </div>
            <div class="col-md-12 mb-3">
                <label for="">Password</label>
            <input type="text" class="form-control w-50" name="password">
            </div>

            <div class="col-md-12 mb-3">
         <label for="">Outlet</label>
            <select name="outlet_id" id="" class="form-control w-50">
                @foreach ($outlet as $list)
                <option value="{{ $list->id }}">{{ $list->nama_outlet }}</option>
                @endforeach
            </select>
             <button type="submit" class="btn btn-success sm mt-4">
                Submit
            </button>
            </div>


            </div>

        </div>
        </form>


</div>
</div>

@endsection
