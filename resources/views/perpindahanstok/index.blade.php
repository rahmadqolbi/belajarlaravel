@extends('layouts.app')
@section('title', 'Perpindahan Stok')

@section('content')

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<form action="{{ route('perpindahanstok.add') }}" method="POST">
    @csrf
    @method('POST')

<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Form Perpindahan Stok</h5>
        </div>

        <div class="card-body">

            {{-- HEADER --}}
            <div class="row mb-4">
                <div class="col-md-4">
                    <label>Kode Transfer</label>
                    <input type="text" class="form-control" name="kode_transfer" value="{{ $kode }}" readonly>
                </div>
                <div class="col-md-4">
                    <label>Tanggal</label>
                    <input type="date" class="form-control" name="tanggal" value="{{ date('Y-m-d') }}">
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label>Outlet Asal</label>
                    <select class="form-control" name="outlet_asal_id">
                        <option value="">-- Pilih Outlet Asal --</option>
                        @foreach($outlet as $list)
                            <option value="{{ $list->id }}">{{ $list->nama_outlet }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Outlet Tujuan</label>
                    <select class="form-control" name="outlet_tujuan_id">
                        <option value="">-- Pilih Outlet Tujuan --</option>
                        @foreach($outlet as $list)
                            <option value="{{ $list->id }}">{{ $list->nama_outlet }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- DETAIL PRODUK --}}
            <div class="card mb-3">
                <div class="card-header bg-light">Detail Barang</div>
                <div class="card-body p-0">
                    <table class="table table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50%">Produk</th>
                                <th width="20%">Stok Tersedia</th>
                                <th width="20%">Qty Pindah</th>
                                <th width="10%">#</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            <tr>
                                <td>
                                    <select class="form-control product-select" name="produk_id[]">
                                        <option value="">-- Pilih Produk --</option>
                                        @foreach($produks as $pro)
                                            <option value="{{ $pro->id }}" data-stok="{{ $pro->stok }}">
                                                {{ $pro->nama_barang }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control stok-tersedia" readonly placeholder="-">
                                </td>
                                <td>
                                    <input type="number" class="form-control qty" name="qty[]" min="1" placeholder="0">
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-danger btn-sm btn-delete">X</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <button type="button" class="btn btn-outline-primary mb-3" id="add">
                + Tambah Baris
            </button>

            <div class="mb-3">
                <label>Catatan (opsional)</label>
                <textarea name="catatan" class="form-control" rows="2" placeholder="Contoh: Transfer stok mingguan..."></textarea>
            </div>

            <div class="text-end">
                <a href="" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">💾 Simpan Transfer</button>
            </div>

        </div>
    </div>
</div>
</form>

<script>
// Template baris baru — dibuat sebagai function biasa, tidak pakai Blade di dalam JS
function buatBaris() {
    // Ambil semua option dari baris pertama yang sudah ada
    let optionHtml = $('#tbody tr:first').find('.product-select').html();

    return `
        <tr>
            <td>
                <select class="form-control product-select" name="produk_id[]">
                    ${optionHtml}
                </select>
            </td>
            <td>
                <input type="text" class="form-control stok-tersedia" readonly placeholder="-">
            </td>
            <td>
                <input type="number" class="form-control qty" name="qty[]" min="1" placeholder="0">
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm btn-delete">X</button>
            </td>
        </tr>
    `;
}

$(document).ready(function () {

     $('.product-select').select2({
        theme: 'bootstrap4',
        width: '100%',
        placeholder: '-- Pilih Produk --',
    });
    // Tambah baris
    $('#add').click(function () {
        $('#tbody').append(buatBaris());
        baris.find('.product-select').select2({
        theme: 'bootstrap4',
        width: '100%',
        placeholder: '-- Pilih Produk --',
    });
    });

    // Hapus baris — minimal 1 baris harus tersisa
    $(document).on('click', '.btn-delete', function () {
        if ($('#tbody tr').length > 1) {
            $(this).closest('tr').remove();
        } else {
            alert('Minimal harus ada 1 baris produk!');
        }
    });

    // Saat produk dipilih → tampilkan stok tersedia
   // Saat outlet asal berubah → reset semua baris
$('select[name="outlet_asal_id"]').on('change', function () {
    // Kosongkan semua stok tersedia saat outlet asal ganti
    $('.stok-tersedia').val('-');
    $('.product-select').val(null).trigger('change');
});

// Saat produk dipilih → fetch stok dari outlet asal
$(document).on('select2:select', '.product-select', function () {
    let produkId  = $(this).val();
    let outletId  = $('select[name="outlet_asal_id"]').val();
    let row       = $(this).closest('tr');

    // Validasi outlet asal harus dipilih dulu
    if (!outletId) {
        alert('Pilih outlet asal dulu!');
        $(this).val('');
        return;
    }

    if (!produkId) {
        row.find('.stok-tersedia').val('-');
        row.find('.qty').attr('max', 0);
        return;
    }

    // Fetch stok dari server
    $.get(`/stok-outlet/${produkId}/${outletId}`, function (res) {
        row.find('.stok-tersedia').val(res.stok + ' pcs');
        row.find('.qty').attr('max', res.stok);

        // Warna merah kalau stok 0
        if (res.stok == 0) {
            row.find('.stok-tersedia').addClass('text-danger fw-bold');
        } else {
            row.find('.stok-tersedia').removeClass('text-danger fw-bold');
        }
    });
});

    // Validasi qty tidak boleh melebihi stok
    $(document).on('input', '.qty', function () {
        let max = parseInt($(this).attr('max')) || 0;
        let val = parseInt($(this).val()) || 0;
        if (max > 0 && val > max) {
            $(this).val(max);
            alert('Qty tidak boleh melebihi stok tersedia (' + max + ')!');
        }
    });

    // Validasi sebelum submit
    $('form').on('submit', function (e) {
        let outletAsal = $('select[name="outlet_asal_id"]').val();
        let outletTujuan = $('select[name="outlet_tujuan_id"]').val();

        if (!outletAsal || !outletTujuan) {
            e.preventDefault();
            alert('Outlet asal dan tujuan harus dipilih!');
            return;
        }

        if (outletAsal === outletTujuan) {
            e.preventDefault();
            alert('Outlet asal dan tujuan tidak boleh sama!');
            return;
        }

        let adaProduk = false;
        let adaError = false;

        $('#tbody tr').each(function () {
            let produk = $(this).find('.product-select').val();
            let qty = parseInt($(this).find('.qty').val()) || 0;

            if (produk) {
                adaProduk = true;
                if (qty <= 0) adaError = true;
            }
        });

        if (!adaProduk) {
            e.preventDefault();
            alert('Minimal pilih 1 produk!');
            return;
        }

        if (adaError) {
            e.preventDefault();
            alert('Qty produk belum diisi!');
            return;
        }
    });

});
</script>
@endsection
