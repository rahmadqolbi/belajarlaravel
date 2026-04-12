@extends('layouts.app')

@section('title', 'Dashboard')
@section('content')

  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">

<style>
.inv-card {
    border: none;
    border-radius: 16px;
    overflow: hidden;
    transition: transform 0.2s, box-shadow 0.2s;
    box-shadow: 0 2px 12px rgba(0,0,0,0.07);
}
.inv-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(0,0,0,0.12);
}
.inv-card .card-body {
    padding: 1.4rem 1.5rem;
}
.inv-card .inv-label {
    font-family: 'DM Sans', sans-serif;
    font-size: 0.72rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    margin-bottom: 0.4rem;
    opacity: 0.75;
}
.inv-card .inv-value {
    font-family:  sans-serif;
    font-size: 1.65rem;
    font-weight: 800;
    line-height: 1.1;
    margin-bottom: 0.4rem;
}
.inv-card .inv-sub {
    font-size: 0.75rem;
    opacity: 0.65;
    font-family: 'DM Sans', sans-serif;
}
.inv-card .inv-icon {
    width: 52px; height: 52px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem;
    flex-shrink: 0;
}
.inv-card .inv-bar {
    height: 4px;
    border-radius: 999px;
    margin-top: 0.9rem;
    background: rgba(255,255,255,0.25);
    overflow: hidden;
}
.inv-card .inv-bar-fill {
    height: 100%;
    border-radius: 999px;
    background: rgba(255,255,255,0.7);
}

/* Card 1 - Penjualan Bulan Ini (Biru) */

.inv-card-orange .inv-icon { background: rgba(255,255,255,0.2); color: #696969; }
</style>

<div class="row mb-4">

    {{-- Card 1: Penjualan Bulan Ini --}}
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card inv-card inv-card-blue h-100">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">

                    <div>
                        <div class="inv-label text-success">Total Penjualan</div>
                        <div class="inv-value ">Rp {{ number_format($totalPenjualan ?? 0, 0, ',', '.') }}</div>
                        {{-- <div class="inv-sub">
                            @if(($pctPenjualan ?? 0) >= 0)
                                ▲ {{ abs($pctPenjualan ?? 0) }}% dari bulan lalu
                            @else
                                ▼ {{ abs($pctPenjualan ?? 0) }}% dari bulan lalu
                            @endif
                        </div> --}}
                    </div>

                    <div class="inv-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
                <div class="inv-bar">
                    <div class="inv-bar-fill" style="width: 72%"></div>
                </div>
            </div>
        </div>
    </div>
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card inv-card inv-card-blue h-100">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">

                    <div>
                        <div class="inv-label text-success">Total Profit</div>
                        <div class="inv-value">Rp {{ number_format($totalProfit ?? 0, 0, ',', '.') }}</div>
                        {{-- <div class="inv-sub">
                            @if(($pctPenjualan ?? 0) >= 0)
                                ▲ {{ abs($pctPenjualan ?? 0) }}% dari bulan lalu
                            @else
                                ▼ {{ abs($pctPenjualan ?? 0) }}% dari bulan lalu
                            @endif
                        </div> --}}
                    </div>

                    <div class="inv-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
                <div class="inv-bar">
                    <div class="inv-bar-fill" style="width: 72%"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Card 2: Total Transaksi --}}
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card inv-card inv-card-teal h-100">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div>
                        <div class="inv-label text-success">Transaksi Berhasil</div>
                        <div class="inv-value">{{ $transaksiBerhasil ?? 0 }}</div>
                        {{-- <div class="inv-sub">Transaksi bulan ini</div> --}}
                    </div>
                    <div class="inv-icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                </div>
                <div class="inv-bar">
                    <div class="inv-bar-fill" style="width: 58%"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Card 3: Total Produk --}}
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card inv-card inv-card-purple h-100">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div>
                        <div class="inv-label text-primary">Total Produk</div>
                        <div class="inv-value">{{ $totalProduk ?? 0 }}</div>
                        <div class="inv-sub">Produk terdaftar</div>
                    </div>
                    <div class="inv-icon">
                        <i class="fas fa-boxes"></i>
                    </div>
                </div>
                <div class="inv-bar">
                    <div class="inv-bar-fill" style="width: 85%"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Card 4: Stok Kritis --}}
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card inv-card inv-card-orange h-100">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div>
                        <div class="inv-label text-danger">Stok Menipis</div>
                        <div class="inv-value">{{ $stokMenipis ?? 0 }}</div>
                        <div class="inv-sub">Produk stok ≤ 4</div>
                    </div>
                    <div class="inv-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                </div>
                <div class="inv-bar">
                    <div class="inv-bar-fill" style="width: 40%"></div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
