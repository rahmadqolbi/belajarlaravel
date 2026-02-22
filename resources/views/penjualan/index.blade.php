@extends('layouts.app')
@section('title', 'Penjualan')

@section('content')

<div class="container-fluid">
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
@if (session('warning'))
    <div class="alert alert-warning">
        {{ session('warning') }}
    </div>
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
                        <th>Metode</th>
                        <th>User</th>
                        <th>Status</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penjualan as $pen)
                        <tr>
                    <td class="text-center">{{ $penjualan->firstItem() + $loop->index. '.'}}</td>
                    <td>{{ $pen->kode }}</td>
                    <td>{{ $pen->tanggal }}</td>
                    <td>{{ $pen->total }}</td>
                    <td>{{ $pen->metode_pembayaran }}</td>
                    <td>{{ $pen->user ? $pen->user->email : '-' }}</td>
                    <td>
                        @if ($pen->status === 'BERHASIL')
                            <span class="badge bg-success text-light">Berhasil</span>
                        @elseif ($pen->status === 'DIBATALKAN')
                            <span class="badge bg-danger text-light">Dibatalkan</span>
                        @endif
                    </td>
                    <td>
                        @if ($pen->status === 'BERHASIL')
                        <a href="{{ route('penjualan.update', $pen->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('penjualan.cancel', $pen->id) }}"
      method="POST"
      style="display:inline;">
    @csrf
                        <button class="btn btn-danger btn-sm"
        onclick="return confirm('Batalkan transaksi ini? Stok akan dikembalikan.')">
        Cancel
    </button>
</form>
 @else
        <a href=""
           class="btn btn-dark btn-sm">Detail</a>
    @endif
                    </td>
                        </tr>

                    @endforeach

                </tbody>
            </table>

        </div>
    </div>

    <div class="mt-3 d-flex justify-content-end">
        {{-- {{ $penjualans->links() }} --}}
        {{ $penjualan->appends(request()->query())->links() }}
    </div>

</div>
@endsection
