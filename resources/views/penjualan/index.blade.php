@extends('layouts.app')
@section('title', 'Penjualan')

@section('content')

<div class="container-fluid">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0">Data Penjualan</h4>
            <small class="text-muted">Daftar seluruh transaksi penjualan</small>
        </div>
        <a href="{{ route('penjualan.add') }}" class="btn btn-primary">
            + Tambah Penjualan
        </a>
    </div>

    {{-- FILTER & SEARCH --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('penjualan') }}">
                <div class="row g-3">

                    <div class="col-md-3">
                        <label>Search</label>
                        <input type="text" name="search"
                               class="form-control"
                               placeholder="Kode / User..."
                               value="{{ request('search') }}">
                    </div>

                    <div class="col-md-2">
                        <label>Dari</label>
                        <input type="date" name="from"
                               class="form-control"
                               value="{{ request('from') }}">
                    </div>

                    <div class="col-md-2">
                        <label>Sampai</label>
                        <input type="date" name="to"
                               class="form-control"
                               value="{{ request('to') }}">
                    </div>

                    <div class="col-md-2">
                        <label>Metode</label>
                        <select name="metode" class="form-control">
                            <option value="">Semua</option>
                            <option value="CASH">CASH</option>
                            <option value="TRANSFER">TRANSFER</option>
                            <option value="QRIS">QRIS</option>
                        </select>
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-primary w-100">
                            🔍 Filter
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">

            <table class="table table-hover table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Kode</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Dibayar</th>
                        <th>Metode</th>
                        <th>User</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Loop Data Disini --}}
                </tbody>
            </table>

        </div>
    </div>

    <div class="mt-3 d-flex justify-content-end">
        {{-- {{ $penjualans->links() }} --}}
    </div>

</div>
@endsection
