@extends('layouts.app')

@section('title', 'Tambah Produk Baru')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8f9fc; }
    .card { border: none; border-radius: 15px; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.05); }
    .card-header { background-color: #ffffff; border-bottom: 1px solid #f1f1f1; font-weight: 700; color: #4e73df; padding: 1.25rem; }
    .form-label { font-size: 0.75rem; font-weight: 700; color: #4e73df; text-transform: uppercase; letter-spacing: 0.025em; margin-bottom: 0.5rem; }
    .form-control:focus { border-color: #4e73df; box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.1); }
    .input-group-text { border-radius: 10px 0 0 10px; background-color: #f8f9fc; border-right: none; }
    .has-icon .form-control { border-radius: 0 10px 10px 0; }
    .text-danger { font-size: 0.75rem; font-weight: 600; }
</style>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <form action="{{ route('produk') }}" method="POST">
                @csrf
                @method('post')

                <div class="row">
                    <div class="col-md-7">
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-light"><i class="fas fa-info-circle me-2"></i> Informasi Dasar</div>
                            <div class="card shadow card-body p-4">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Kode Barang</label>
                                        <input type="text" class="form-control bg-light fw-bold text-primary @error('kode') is-invalid @enderror"
                                               name="kode" value="{{ $nextkode }}" readonly>
                                        @error('kode') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Kategori</label>
                                        <select class="form-control @error('kategori_id') is-invalid @enderror" name="kategori_id">
                                            <option value="">-- Pilih Kategori --</option>
                                            @foreach ($data as $item)
                                                <option value="{{ $item->id }}" {{ old('kategori_id') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->nama_kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('kategori_id') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nama Barang</label>
                                    <input type="text" name="nama_barang" value="{{ old('nama_barang') }}"
                                           class="form-control text-uppercase @error('nama_barang') is-invalid @enderror"
                                           placeholder="Masukkan nama produk lengkap...">
                                    @error('nama_barang') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Outlet</label>
                                        <select name="outlet_id" class="form-control">
                                            <option value="">-- Semua Outlet --</option>
                                            @foreach($outlets as $outlet)
                                                <option value="{{ $outlet->id }}">{{ $outlet->nama_outlet }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Stok Awal</label>
                                        <input type="number" name="stok" class="form-control" placeholder="0" min="0">
                                        <small class="text-muted" style="font-size: 0.7rem;">Stok saat ini di gudang</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="card shadow-sm card mb-4 border-left-primary">
                            <div class="card-header"><i class="fas fa-tag me-2"></i> Pengaturan Harga</div>
                            <div class="card-body p-4">
                                <div class="mb-3">
                                    <label class="form-label">Harga Modal (HPP)</label>
                                    <div class="input-group has-icon">
                                        <span class="input-group-text small fw-bold">Rp</span>
                                        <input type="number" name="harga_modal" value="{{ old('harga_modal') }}"
                                               class="form-control @error('harga_modal') is-invalid @enderror" placeholder="0">
                                    </div>
                                    @error('harga_modal') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Harga Jual</label>
                                    <div class="input-group has-icon">
                                        <span class="input-group-text small fw-bold">Rp</span>
                                        <input type="number" name="harga" value="{{ old('harga') }}"
                                               class="form-control @error('harga') is-invalid @enderror" placeholder="0">
                                    </div>
                                    @error('harga') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="bg-light p-3 rounded-3 mb-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="small text-muted fw-bold">Estimasi Profit</span>
                                        <span id="profit-label" class="badge bg-success text-light">Rp 0</span>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 py-3 mb-2 shadow-sm" style="border-radius: 12px; font-weight: 700;">
                                    <i class="fas fa-plus-circle me-2"></i> Simpan Produk
                                </button>
                                <a href="{{ route('produk') }}" class="btn btn-link w-100 text-muted small text-decoration-none">Kembali ke Daftar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Script sederhana untuk hitung estimasi profit di sisi client
    const hargaModal = document.getElementsByName('harga_modal')[0];
    const hargaJual = document.getElementsByName('harga')[0];
    const profitLabel = document.getElementById('profit-label');

    function calculateProfit() {
        const modal = parseInt(hargaModal.value) || 0;
        const jual = parseInt(hargaJual.value) || 0;
        const profit = jual - modal;
        profitLabel.innerText = 'Rp ' + profit.toLocaleString('id-ID');

        if(profit < 0) {
            profitLabel.classList.replace('bg-success', 'bg-danger');
        } else {
            profitLabel.classList.replace('bg-danger', 'bg-success');
        }
    }

    hargaModal.addEventListener('input', calculateProfit);
    hargaJual.addEventListener('input', calculateProfit);
</script>
@endsection
