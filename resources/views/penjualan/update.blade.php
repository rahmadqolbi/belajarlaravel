@extends('layouts.app')
@section('title', 'Form Edit Penjualan')

@section('content')
<form action="{{ route('penjualan.update', $penjualan->id) }}" method="POST">
    @csrf
    @method('PUT')


<div class="container-fluid">


    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Form Edit Penjualan</h5>
        </div>

        <div class="card-body">

            {{-- ================= HEADER TRANSAKSI ================= --}}
            <div class="row mb-4">

                <div class="col-md-4">
                    <label>Kode Transaksi</label>
                    <input type="text" class="form-control" name="kode" value="{{ $penjualan->kode}}" readonly>
                </div>

                <div class="col-md-4">
                    <label>Tanggal</label>
                    <input type="date" class="form-control" value="{{ $penjualan->tanggal }}" name="tanggal">
                </div>

                <div class="col-md-4">
                    <label>Metode Pembayaran</label>
                    <select class="form-control" name="metode_pembayaran">

                        <option value="CASH"{{ old('metode_pembayaran', $penjualan->metode_pembayaran) == 'CASH' ? 'selected' : ''}}>CASH</option>
                        <option value="TRANSFER"{{ old('metode_pembayaran', $penjualan->metode_pembayaran) == 'TRANSFER' ? 'selected' : ''}}>TRANSFER</option>
                        <option value="QRIS"{{ old('metode_pembayaran', $penjualan->metode_pembayaran) == 'QRIS' ? 'selected' : ''}}>QRIS</option>
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

@if(old('produk_id'))
    {{-- Jika ada input lama (validasi gagal) --}}
    @foreach(old('produk_id') as $index => $oldProduk)
        <tr>
            <td>
                <select name="produk_id[]"
                    class="form-control product-select @error('produk_id.' . $index) is-invalid @enderror">

                    <option value="">-- Pilih Produk --</option>

                    @foreach ($produk as $pro)
                        <option value="{{ $pro->id }}"
                            data-harga="{{ $pro->harga }}"
                            {{ $oldProduk == $pro->id ? 'selected' : '' }}>
                            {{ $pro->nama_barang }}
                        </option>
                    @endforeach
                </select>
                @error('produk_id.' . $index)
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </td>
            <td>
               <input type="number" name="qty[]" class="form-control text-end qty"
       value="{{ old('qty.' . $index, $penjualan_detail->qty) }}">
            </td>
            <td>
                <input type="text" name="harga[]" class="form-control text-end harga"
       value="{{ $penjualan_detail->harga }}"
       data-value="{{ $penjualan_detail->harga }}" readonly>
            </td>
          <td>
    <input type="text"
           name="subtotal[]"
           class="form-control text-end bg-light subtotal"
           value="{{ old('subtotal.' . $index, number_format($penjualan_detail->subtotal, 0, ',', '.')) }}"
           readonly>
</td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm btn-delete">X</button>
            </td>
        </tr>
    @endforeach

@elseif(isset($detailPenjualan) && $detailPenjualan->count() > 0)
    {{-- Tampilkan detail penjualan dari database --}}
    @foreach($detailPenjualan as $detail)
        <tr>
            <td>
                <select name="produk_id[]" class="form-control product-select">
                    <option value="">-- Pilih Produk --</option>
                    @foreach ($produk as $pro)
                        <option value="{{ $pro->id }}"
                            data-harga="{{ $pro->harga }}"
                            {{ $detail->produk_id == $pro->id ? 'selected' : '' }}>
                            {{ $pro->nama_barang }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="number" name="qty[]" class="form-control text-end qty" value="{{ $detail->qty }}">
            </td>
            <td>
                <input type="text" name="harga[]" class="form-control text-end harga" value="{{ $detail->harga }}" data-value="{{ $detail->harga }}" readonly>
            </td>
            <td>
                <input type="text" name="subtotal[]" class="form-control text-end bg-light subtotal" value="{{ number_format($detail->subtotal,0,',','.') }}" readonly>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm btn-delete">X</button>
            </td>
        </tr>
    @endforeach

@else
    {{-- Baris kosong default --}}
    <tr>
        <td colspan="5" class="text-center">Belum ada produk</td>
    </tr>
@endif

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

                         <div class="d-flex justify-content-between mb-2 align-items-center">
    <span>Total</span>

    <input
    type="text"
    id="grandTotal"
    class="form-control w-50 text-end fw-bold"
     value="{{ old('total', $grandTotal) ? 'Rp '.number_format((int) old('total', $grandTotal),0,',','.') : '' }}"
    readonly
>
</div>

                    <input type="hidden" name="total" id="totalHidden">

                            <div class="mb-2">
                                <label>Dibayar</label>
                                <input type="number"
                                    id="dibayar"
                                    class="form-control text-end @error('dibayar') is-invalid @enderror" name="dibayar" value="{{ $penjualan->dibayar }}"
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

       $('#grandTotal').val(formatRupiah(subtotal));
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

$(document).ready(function() {
    hitungTotal2(); // hitung subtotal & grandTotal awal dari database
});


$(document)
   $(document).ready(function(){

    $('#add').click(function(){

        let newRow = $(`
            <tr>
                                <td>
                                        <select class="form-control product-select @error('produk_id') is-invalid @enderror"
                                name="produk_id[]">

                            <option value="">-- Pilih Produk --</option>

                            @foreach ($produk as $pro)
                                <option value="{{ $pro->id }}"
                                    data-harga="{{ $pro->harga }}"
                                    {{ old('produk_id.0') == $pro->id ? 'selected' : '' }}>
                                    {{ $pro->nama_barang }}
                                </option>
                            @endforeach

                        </select>
                        @error('produk_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror

                                    </td>

                               <td>
                                    <input type="number" class="form-control text-end qty @error('qty') is-invalid @enderror"  name="qty[]" ">
                                                                        @error('qty')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
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

    let currentSelect = $(this);
    let currentValue = currentSelect.val();

    if(!currentValue) return; // kalau kosong, abaikan

    let duplicate = false;

    $('.product-select').not(currentSelect).each(function(){

        if($(this).val() === currentValue){
            duplicate = true;
            return false; // hentikan loop
        }

    });

    if(duplicate){
        alert('Produk sudah dipilih!');
        currentSelect.val(null).trigger('change');
    }

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
$('form').on('submit', function(){

    $('#tbody tr').each(function(){

        let produk = $(this).find('.product-select').val();
        let qty = parseFloat($(this).find('.qty').val()) || 0;

        if(!produk || qty <= 0){
            $(this).find('input, select').prop('disabled', true);
        }

    });

    hitungTotal2();
});
$('form').on('submit', function(e){

    hitungTotal2(); // pastikan total terbaru

    let total = parseFloat($('#totalHidden').val()) || 0;
    let dibayar = parseFloat($('#dibayar').val()) || 0;

    let adaProduk = false;
    let adaErrorProduk = false;

    $('#tbody tr').each(function(){

        let produk = $(this).find('.product-select').val();
        let qty = parseFloat($(this).find('.qty').val()) || 0;

        // kalau baris benar-benar kosong → abaikan
        if(!produk && qty === 0){
            return;
        }

        // kalau ada produk
        if(produk){
            adaProduk = true;

            if(qty <= 0){
                adaErrorProduk = true;
            }
        }

    });

    // ❌ tidak ada produk sama sekali
    if(!adaProduk){
        e.preventDefault();
        alert("Minimal pilih 1 produk!");
        return;
    }

    // ❌ produk ada tapi qty kosong
    if(adaErrorProduk){
        e.preventDefault();
        alert("Qty produk belum diisi!");
        return;
    }

    // ❌ pembayaran kosong
    if(dibayar <= 0){
        e.preventDefault();
        alert("Pembayaran belum diisi!");
        return;
    }

    // ❌ uang kurang
    if(dibayar < total){
        e.preventDefault();
        alert("Uang dibayar kurang!");
        return;
    }
     if(dibayar < total){
        e.preventDefault();
        alert("Uang dibayar kurang!");
        return;
    }

});

</script>
@endsection
