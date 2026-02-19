@extends('layouts.app')
@section('title', 'Form Penjualan')

@section('content')
<form action="{{ route('penjualan') }}" method="POST">
    @csrf
    @method('POST')
<div class="container-fluid">


    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Form Penjualan</h5>
        </div>

        <div class="card-body">

            {{-- ================= HEADER TRANSAKSI ================= --}}
            <div class="row mb-4">

                <div class="col-md-4">
                    <label>Kode Transaksi</label>
                    <input type="text" class="form-control" name="kode" value="{{ $kode ?? '' }}" readonly>
                </div>

                <div class="col-md-4">
                    <label>Tanggal</label>
                    <input type="date" class="form-control" value="{{ date('Y-m-d') }}" name="tanggal">
                </div>

                <div class="col-md-4">
                    <label>Metode Pembayaran</label>
                    <select class="form-control" name="metode_pembayaran">
                        <option value="CASH">CASH</option>
                        <option value="TRANSFER">TRANSFER</option>
                        <option value="QRIS">QRIS</option>
                    </select>
                </div>

            </div>

            {{-- ================= DETAIL BARANG ================= --}}
            <div class="card mb-3">
                <div class="card-header bg-light">
                    Detail Barang
                </div>
                <div class="card-body p-0">

                    <table class="table table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="30%">Produk</th>
                                <th width="10%">Qty</th>
                                <th width="15%">Harga</th>
                                <th width="20%">Subtotal</th>
                                <th width="5%">#</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            <tr>
                                <td>
                                        <select class="form-control product-select" name="produk_id[]">
                                            <option>-- Pilih Produk --</option>
                                           @foreach ($produk as $pro)
                                                <option
                                                    value="{{ $pro->id }}"
                                                    data-harga="{{ $pro->harga }}">
                                                    {{ $pro->nama_barang }}
                                                </option>
                                                @endforeach
                                        </select>
                                    </td>

                                <td>
                                    <input type="number" class="form-control text-end qty"  name="qty[]">
                                </td>
                                <td>
                                        <input type="text"
                                    class="form-control text-end harga"
                                    placeholder="0" readonly name="harga[]">
                                    </td>
                                <td>
                                <input type="text" class="form-control text-end bg-light subtotal" name="subtotal[]" readonly placeholder="0">

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

            {{-- ================= RINGKASAN TOTAL ================= --}}
            <div class="row justify-content-end">
                <div class="col-md-4">

                    <div class="card shadow-sm">
                        <div class="card-body">

                           <div class="d-flex justify-content-between mb-2">
                        <span>Total</span>
                        <strong id="grandTotal">Rp 0</strong>
                    </div>

                    <input type="hidden" name="total" id="totalHidden">

                            <div class="mb-2">
                                <label>Dibayar</label>
                                <input type="number"
                                    id="dibayar"
                                    class="form-control text-end @error('dibayar') is-invalid @enderror" name="dibayar"
                                    >
                                    @error('dibayar')
    <div class="text-danger">{{ $message }}</div>
@enderror
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <span>Kembalian</span>
                                <strong id="kembalian" class="text-success">Rp 0</strong>
                            </div>

                            <button type="submit" class="btn btn-success w-100">
                                💾 Simpan Transaksi
                            </button>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
</form>
<script>

function formatRupiah(angka) {
    return "Rp " + Number(angka).toLocaleString('id-ID');
}
let totalGlobal = 0;




function hitungKembalian(){

    let dibayarText = $("#dibayar").val();

    let dibayar = parseInt(dibayarText.replace(/[^0-9]/g, "")) || 0;

    let kembalian = dibayar - totalGlobal;

    $("#kembalian").text("Rp. " + kembalian.toLocaleString("id-ID"));
}


function hitungTotal2(){

    let subtotal = 0;

    $('#tbody tr').each(function(){

        let qty = parseFloat($(this).find('.qty').val()) || 0;
        let harga = $(this).find('.harga').data('value') || 0;

        let total = qty * harga;

        $(this).find('.subtotal').val(formatRupiah(total));

        subtotal += total;
    });

    totalGlobal = subtotal;

    $('#grandTotal').text(formatRupiah(subtotal));
    $('#totalHidden').val(subtotal);

    hitungKembalian();
}


// format rupiah

// hitung total
function hitungTotal() {

    var subtotal = 0;

    $('table tbody tr').each(function() {

        var qty = parseFloat($(this).find('.qty').val()) || 0;

        // ambil angka asli, bukan text
        var harga = $(this).find('.harga').data('value') || 0;

        var total = qty * harga;

        $(this).find('.subtotal').val(formatRupiah(total));

        subtotal += total;
    });

    $('#subtotal').val(formatRupiah(subtotal));
}


$(document).ready(function() {

    // otomatis jalan saat input berubah
    $('table').on('input', '.qty, .harga', function(){
        hitungTotal();
    });
     $('table').on('input', '.qty', function(){
        hitungTotal2();
    });


    // hitung saat pertama load
    hitungTotal();
    hitungTotal2();
});
$('#dibayar').on('input', function(){
    hitungKembalian();
});



$(document)
   $(document).ready(function(){

    $('#add').click(function(){

        let newRow = $(`
            <tr>
                                <td>
                                        <select class="form-control product-select">
                                            <option>-- Pilih Produk --</option>
                                           @foreach ($produk as $pro)
                                                <option
                                                    value="{{ $pro->id }}"
                                                    data-harga="{{ $pro->harga }}">
                                                    {{ $pro->nama_barang }}
                                                </option>
                                                @endforeach
                                        </select>
                                    </td>

                                <td>
                                    <input type="number" class="form-control text-end qty" name="qty[]">
                                </td>
                                <td>
                                        <input type="text"
                                    class="form-control text-end harga"
                                    placeholder="0" readonly name="harga[]">
                                    </td>
                                <td>
                               <input type="text" class="form-control text-end bg-light subtotal" name="subtotal[]" readonly placeholder="0">

                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-danger btn-sm btn-delete">X</button>
                                </td>
                            </tr>
        `);

        $('#tbody').append(newRow);

        // 🔥 INIT SELECT2 HANYA UNTUK YANG BARU
        newRow.find('.product-select').select2({
            theme: 'bootstrap4',
            width: '100%',
            minimumInputLength: 1
        });

    });

});
   $(document).on('click', '.btn-delete', function(){
    $(this).closest('tr').remove();
    hitungTotal2();
});


$(document).ready(function(){
    $('.product-select').select2({
    theme: 'bootstrap4',
    width: '100%',
    minimumInputLength: 1
});

 $(document).on('change', '.product-select', function(){

        let values = [];

        $('.product-select').each(function(){
            let val = $(this).val();

            if(values.includes(val)){
                alert('Produk sudah dipilih!');
                $(this).val(null).trigger('change');
            }

            values.push(val);
        });

    });
    $(document).on('change', '.product-select', function(){

    let harga = $(this).find(':selected').data('harga') || 0;
    let row = $(this).closest('tr');

    row.find('.harga')
        .data('value', harga) // simpan angka asli
        .val(formatRupiah(harga)); // tampilkan rupiah

    hitungTotal();

    // Saat produk dipilih (harga berubah)
$(document).on('change', '.product-select', function(){
    let harga = $(this).find(':selected').data('harga') || 0;
    let row = $(this).closest('tr');

    row.find('.harga')
        .data('value', harga)
        .val(formatRupiah(harga));

    hitungTotal2(); // 🔥 PANGGIL DI SINI
});

$(document).on('change', '.product-select', function(){

    let harga = $(this).find(':selected').data('harga') || 0;

    let row = $(this).closest('tr');

    // tampilkan harga ke input
    row.find('.harga').val(formatRupiah(harga));

    // simpan harga asli ke data-value
    row.find('.harga').data('value', harga);

    hitungTotal2();
});

});




});

$('#add').click(function(){

    let newRow = $(`<tr> .... </tr>`);

    $('#tbody').append(newRow);

    $('html, body').animate({
        scrollTop: newRow.offset().top
    }, 200);

});



</script>
@endsection
