@extends('layouts.app')

@section('title', 'Penyesuaian Stok')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #f8f9fc;
    }

    /* Header Styling */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.5rem;
    }

    .page-title {
        color: #5a5c69;
        font-weight: 700;
        font-size: 1.5rem;
        margin-bottom: 0;
    }

    .page-subtitle {
        color: #b7b9cc;
        font-size: 0.85rem;
    }

    /* Card & Filter Styling */
    .custom-card {
        background: #fff;
        border: none;
        border-radius: 8px;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.05);
        margin-bottom: 1.5rem;
    }

    .filter-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: #858796;
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-control-custom {
        border: 1px solid #d1d3e2;
        border-radius: 5px;
        padding: 0.45rem 0.75rem;
        font-size: 0.9rem;
        color: #6e707e;
    }

    .btn-filter {
        background-color: #4e73df;
        border: none;
        color: white;
        padding: 0.45rem 1.5rem;
        border-radius: 5px;
        width: 100%;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-filter:hover {
        background-color: #2e59d9;
        box-shadow: 0 4px 8px rgba(78, 115, 223, 0.2);
    }

    /* Table Styling */
    .table-container {
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
    }

    .table-custom {
        margin-bottom: 0;
    }

    .table-custom thead {
        background-color: #f8f9fc;
    }

    .table-custom thead th {
        color: #4e73df;
        font-weight: 700;
        text-transform: none;
        font-size: 0.9rem;
        border-top: none;
        border-bottom: 2px solid #e3e6f0;
        padding: 1rem;
    }

    .table-custom tbody td {
        padding: 1rem;
        vertical-align: middle;
        color: #5a5c69;
        font-size: 0.85rem;
        border-bottom: 1px solid #e3e6f0;
    }

    /* Action Buttons */
    .btn-action-view {
        background: #f8f9fc;
        color: #4e73df;
        border: 1px solid #e3e6f0;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.8rem;
    }

    .btn-export-pdf {
        background: #fff;
        color: #e74a3b;
        border: 1px solid #e74a3b;
        padding: 0.4rem 1rem;
        border-radius: 5px;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-export-pdf:hover {
        background: #e74a3b;
        color: #fff;
    }
</style>

<div class="container-fluid">

    <div class="page-header">
        <div>
            <h1 class="page-title">Penyesuaian Stok</h1>
            <p class="page-subtitle">Daftar seluruh transaksi penyesuaian stok</p>
        </div>
        <a href="{{ route('penyesuaianstok.create') }}" class="btn btn-primary px-4 shadow-sm" style="border-radius: 8px; font-weight: 600;">
            <i class="fas fa-plus me-1"></i> Tambah Penyesuaian
        </a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <form class="row align-items-end g-3">
                <div class="col-md-3">
                    <label class="filter-label">Search</label>
                    <input type="text" class="form-control form-control-custom" placeholder="Kode / Produk...">
                </div>
                <div class="col-md-2">
                    <label class="filter-label">Dari</label>
                    <input type="date" class="form-control form-control-custom">
                </div>
                <div class="col-md-2">
                    <label class="filter-label">Sampai</label>
                    <input type="date" class="form-control form-control-custom">
                </div>
                <div class="col-md-3">
                    <label class="filter-label">Alasan</label>
                    <select class="form-select form-control-custom">
                        <option value="">Semua</option>
                        <option value="rusak">Barang Rusak</option>
                        <option value="hilang">Barang Hilang</option>
                        <option value="opname">Stock Opname</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-primary w-100">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow table-container shadow-sm">
        <table class="table table-custom">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Kode Trx</th>
                    <th>Tanggal</th>
                    <th>Nama Produk</th>
                    <th>Selisih</th>
                    <th>Alasan</th>
                    <th>User</th>
                    <th width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td><strong>ADJ-2024001</strong></td>
                    <td>17 Apr 2026</td>
                    <td>Kopi Kapal Api 165gr</td>
                    <td><span class="badge bg-light-danger text-danger fw-bold">-5</span></td>
                    <td>Barang Rusak</td>
                    <td>Admin Utama</td>
                    <td>
                        <button class="btn-action-view"><i class="fas fa-eye"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td><strong>ADJ-2024002</strong></td>
                    <td>17 Apr 2026</td>
                    <td>Minyak Goreng 2L</td>
                    <td><span class="badge bg-light-success text-success fw-bold">+2</span></td>
                    <td>Stock Opname</td>
                    <td>Kasir 1</td>
                    <td>
                        <button class="btn-action-view"><i class="fas fa-eye"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <button class="btn-export-pdf">
            <i class="far fa-file-pdf me-2"></i> Export PDF
        </button>
    </div>
</div>
@endsection
