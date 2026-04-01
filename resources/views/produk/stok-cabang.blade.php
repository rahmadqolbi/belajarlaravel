@extends('layouts.app')
@section('title', 'Stok Per Cabang')
@section('content')

<div class="mb-3">
    <a href="{{ route('produk') }}" class="btn btn-sm btn-secondary">← Kembali</a>
</div>

{{-- Info Produk --}}
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Stok Per Cabang</h5>
    </div>
    <div class="card-body">
        <table class="table table-borderless mb-0" style="width:auto;">
            <tr>
                <td class="text-muted" style="width:130px;">Kode Barang</td>
                <td>: <strong>{{ $produk->kode }}</strong></td>
            </tr>
            <tr>
                <td class="text-muted">Nama Barang</td>
                <td>: <strong>{{ $produk->nama_barang }}</strong></td>
            </tr>
            <tr>
                <td class="text-muted">Harga</td>
                <td>: <strong>Rp {{ number_format($produk->harga, 0, ',', '.') }}</strong></td>
            </tr>
            <tr>
                <td class="text-muted">Total Stok</td>
                <td>:
                    @php $badgeClass = $totalStok > 4 ? 'success' : ($totalStok > 0 ? 'warning' : 'danger'); @endphp
                    <span class="text-light  badge bg-{{ $badgeClass }}">{{ $totalStok }} pcs</span>
                </td>
            </tr>
        </table>
    </div>
</div>

{{-- Stok Per Outlet --}}
<div class="card shadow-sm">
    <div class="card-header bg-light">
        <strong>Rincian Stok Per Outlet</strong>
    </div>
    <div class="card-body p-0">
        <table class="table table-bordered table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Outlet</th>
                    <th>Stok</th>
                    <th>Terakhir Diperbarui</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stokPerOutlet as $index => $item)
                    @php
                        $badge = $item->stok > 4 ? 'success' : ($item->stok > 0 ? 'danger' : 'danger');
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}.</td>
                        <td>{{ $item->nama_outlet }}</td>
                        <td>
                            <span class="text-light badge bg-{{ $badge }}">
                                {{ $item->stok }} pcs
                            </span>
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($item->updated_at)
                                ->timezone('Asia/Jakarta')
                                ->translatedFormat('d F Y H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                            Belum ada data stok untuk produk ini
                        </td>
                    </tr>
                @endforelse
            </tbody>
            @if($stokPerOutlet->count() > 0)
                <tfoot class="table-light">
                    <tr>
                        <td colspan="2" class="text-end fw-bold">Total</td>
                        <td>
                            <span class="text-light badge bg-{{ $badgeClass }}">
                                {{ $totalStok }} pcs
                            </span>
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            @endif
        </table>
    </div>
</div>

@endsection
