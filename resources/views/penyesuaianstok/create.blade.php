@extends('layouts.app')

@section('title', 'Tambah Penyesuaian Stok')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8f9fc; }
    .card { border: none; border-radius: 12px; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.05); }
    .card-header { background-color: #f8f9fc; border-bottom: 1px solid #e3e6f0; font-weight: 700; color: #4e73df; }
    .form-label { font-size: 0.8rem; font-weight: 700; color: #4e73df; text-transform: uppercase; margin-bottom: 0.5rem; }
    .form-control, .form-select { border-radius: 8px; padding: 0.6rem 0.75rem; border: 1px solid #d1d3e2; }
    .form-control:focus { border-color: #bac8f3; box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.1); }

    /* Table Input Style */
    .table-input thead th { font-size: 0.75rem; text-transform: uppercase; color: #858796; padding: 12px; border-top: none; }
    .btn-remove { background: #fff1f0; color: #ff4d4f; border: 1px solid #ffccc7; padding: 0.3rem 0.6rem; border-radius: 6px; }
    .btn-remove:hover { background: #ff4d4f; color: #fff; }

    .bg-light-primary { background: #f0f3ff; border: 1px dashed #4e73df; border-radius: 8px; padding: 20px; }
</style>

<div class="container-fluid">
    <form action="{{ route('penyesuaianstok.add') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header py-3">Informasi Transaksi</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Kode Penyesuaian</label>
                            <input type="text" name="kode_penyesuaian" class="form-control bg-light" value="ADJ-{{ date('YmdHis') }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alasan Utama</label>
                            <select name="alasan" class="form-select" required>
                                <option value="opname">Stock Opname (Rutin)</option>
                                <option value="rusak">Barang Rusak</option>
                                <option value="hilang">Barang Hilang</option>
                                <option value="salah_input">Kesalahan Input</option>
                            </select>
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Catatan Tambahan</label>
                            <textarea name="catatan" class="form-control" rows="3" placeholder="Contoh: Penyesuaian stok gudang rak A..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg shadow-sm" style="border-radius: 10px; font-weight: 600;">
                        <i class="fas fa-save me-2"></i> Simpan Penyesuaian
                    </button>
                    <a href="" class="btn btn-light border" style="border-radius: 10px;">Batal</a>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <span>Daftar Produk yang Disesuaikan</span>
                        <button type="button" class="btn btn-sm btn-outline-primary" id="addRow">
                            <i class="fas fa-plus me-1"></i> Tambah Baris
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-input" id="adjustmentTable">
                                <thead>
                                    <tr>
                                        <th width="40%">Produk</th>
                                        <th width="15%">Stok Sistem</th>
                                        <th width="15%">Stok Fisik</th>
                                        <th width="15%">Selisih</th>
                                        <th width="5%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <select name="produk_id[]" class="form-select produk-select" required>
                                                <option></option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="stok_sistem[]" class="form-control stok-sistem" readonly value="0">
                                        </td>
                                        <td>
                                            <input type="number" name="stok_fisik[]" class="form-control stok-fisik" required min="0">
                                        </td>
                                        <td>
                                            <input type="number" name="selisih[]" class="form-control selisih bg-light" readonly value="0">
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="bg-light-primary mt-3 text-center">
                            <p class="small text-primary mb-0">
                                <i class="fas fa-info-circle me-1"></i>
                                Stok produk akan langsung diperbarui setelah form ini disimpan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Tambah Baris Baru
        $('#addRow').click(function() {
            let newRow = `
                <tr>
                    <td>
                        <select name="produk_id[]" class="form-select produk-select" required>
                            <option value="">Pilih Produk...</option>

                                <option>
                                </option>
                        </select>
                    </td>
                    <td><input type="number" name="stok_sistem[]" class="form-control stok-sistem" readonly value="0"></td>
                    <td><input type="number" name="stok_fisik[]" class="form-control stok-fisik" required min="0"></td>
                    <td><input type="number" name="selisih[]" class="form-control selisih bg-light" readonly value="0"></td>
                    <td><button type="button" class="btn-remove removeRow"><i class="fas fa-times"></i></button></td>
                </tr>`;
            $('#adjustmentTable tbody').append(newRow);
        });

        // Hapus Baris
        $(document).on('click', '.removeRow', function() {
            $(this).closest('tr').remove();
        });

        // Logika Hitung Otomatis
        $(document).on('change', '.produk-select', function() {
            let stokSistem = $(this).find(':selected').data('stok');
            let row = $(this).closest('tr');
            row.find('.stok-sistem').val(stokSistem);
            calculateDiff(row);
        });

        $(document).on('input', '.stok-fisik', function() {
            let row = $(this).closest('tr');
            calculateDiff(row);
        });

        function calculateDiff(row) {
            let sistem = parseInt(row.find('.stok-sistem').val()) || 0;
            let fisik = parseInt(row.find('.stok-fisik').val()) || 0;
            let selisih = fisik - sistem;

            let selisihInput = row.find('.selisih');
            selisihInput.val(selisih);

            // Warna selisih
            if (selisih < 0) {
                selisihInput.addClass('text-danger').removeClass('text-success');
            } else if (selisih > 0) {
                selisihInput.addClass('text-success').removeClass('text-danger');
            } else {
                selisihInput.removeClass('text-danger text-success');
            }
        }
    });
</script>
@endpush
@endsection
