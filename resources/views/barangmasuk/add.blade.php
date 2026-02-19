@extends('layouts.app')
@section('title', 'Tambah Barang Masuk')

@section('content')

 <form action="{{ route('barangmasuk') }}" method="POST">
                        @csrf
                        @method('post')
                   <div class="row">
    <!-- KOLOM KIRI -->
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">Tanggal</label>
            <input type="date" class="form-control text-uppercase @error('tanggal') is-invalid @enderror" name="tanggal" value="{{ old('tanggal') }}">
              @error('tanggal')
                        {{-- <div class="alert alert-danger w-50">{{ $message }}</div> --}}
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
        </div>

      <div class="mb-3">
            <label for="supplier" class="form-label">Supplier</label>
            <select class="custom-select @error('supplier_id') is-invalid @enderror" name="supplier_id">
                 <option value="">-- Pilih Supplier --</option>

                 @foreach ($data as $item)
        <option value="{{ $item->id }}"
            {{ old('supplier_id') == $item->id ? 'selected' : '' }}>
            {{ $item->nama_supplier }}
        </option>
    @endforeach
            </select>

               @error('supplier_id')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                    </div>


        <div class="mb-3">
            <label for="tujuan" class="form-label">Tujuan</label>
            <select class="custom-select @error('tujuan_type') is-invalid @enderror" name="tujuan_type">
                 <option value="">-- Pilih Tujuan --</option>

                  <optgroup label="Gudang">
        @foreach ($gudangs as $gudang)
            <option value="gudang-{{ $gudang->id }}">
                {{ $gudang->nama_gudang }}
            </option>
        @endforeach
                </optgroup>
                <optgroup label="Outlet">
                    @foreach ($outlets as $outlet)
                        <option value="outlet-{{ $outlet->id }}">
                            {{ $outlet->nama_outlet }}
                        </option>
                    @endforeach
                </optgroup>
            </select>
               @error('tujuan_type')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                    </div>
    </div>

    <!-- KOLOM KANAN -->
    <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">No Dokumen</label>
            <input type="text" class="form-control text-uppercase @error('no_dokumen') is-invalid @enderror" name="no_dokumen" value="{{ $noDokumen }}" readonly>
              @error('no_dokumen')
                        {{-- <div class="alert alert-danger w-50">{{ $message }}</div> --}}
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
        </div>

        <div class="mb-3">
            <label class="form-label ">Keterangan</label>
            <input type="text" class="form-control text-uppercase @error('keterangan') is-invalid @enderror" name="keterangan" value="{{ old('keterangan') }}">
               @error('keterangan')
                        {{-- <div class="alert alert-danger w-50">{{ $message }}</div> --}}
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
        </div>

         <div class="mb-3">
            <label class="form-label ">Keterangan</label>
                         <select name="status" id="" class="custom-select">
                            <option value="">--Pilih Status--</option>
                            <option value="DRAFT">DRAFT</option>
                         </select>
                        </div>
            </div>

        </div>
<div>
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Detail Barang Masuk</h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th>Barang</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                            <th>#</th>
                        </tr>
                    </thead>
                 <tbody id="tbody">
<tr>

    <td>
    <select class="form-control product-select" name="barang_id[]">
        <option value="">-- Pilih Barang --</option>
        @foreach ($produk as $pro)
        <option value="{{ $pro->id }}">{{$pro->nama_barang}}</option>
        @endforeach
    </select>
</td>


    <td style="width:110px;">
    <input type="number" class="form-control text-end qty" name="qty[]">
</td>
    <td>
        <input type="number"
            class="form-control text-end harga" name="harga[]">
    </td>
    <td>
       <input type="text" class="form-control text-end bg-light total" name="total[]" readonly>
    </td>


    <td class="text-center">
        <button type="button"
            class="btn btn-danger btn-sm btn-delete">
                      ×
        </button>
    </td>
</tr>
</tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between">
                <button type="button"
                    class="btn btn-outline-primary btn-sm" id="add">
                    + Tambah Baris
                </button>

    <button type="submit" class="btn btn-success">
        <i class="fas fa-save"></i> Simpan

    </button>


            </div>

        </div>


        </div>
                    </form>
                     </div>
<script>
    $(document).ready(function() {

  // fungsi format angka ke Rupiah
  function formatRupiah(angka) {
    return "Rp " + angka.toLocaleString('id-ID');
  }

  // fungsi hitung total tiap baris dan subtotal
  function hitungTotal() {
    var subtotal = 0;

    $('table tbody tr').each(function() {
      var qty = parseFloat($(this).find('.qty').val()) || 0;
      var harga = parseFloat($(this).find('.harga').val()) || 0;
      var total = qty * harga;

      // tampilkan total per baris
      $(this).find('.total').val(formatRupiah(total));

      subtotal += total;
    });

    // tampilkan subtotal
    $('#subtotal').val(formatRupiah(subtotal));
  }

  // jalankan saat input qty atau harga berubah
  $('table').on('input', '.qty, .harga', hitungTotal);

  // jalankan sekali saat page load untuk menghitung jika ada nilai awal
  hitungTotal();

});

   $(document).ready(function(){

    $('#add').click(function(){

        let newRow = $(`
            <tr>
                <td>
                    <select class="form-control product-select" name="barang_id[]">
                        <option value="">-- Pilih Barang --</option>

                        @foreach ($produk as $pro)
                        <option value="{{ $pro->id }}">{{ $pro->nama_barang }}</option>
                        @endforeach
                    </select>
                </td>

                 <td style="width:110px;">
    <input type="number" class="form-control text-end qty" name="qty[]">
</td>

                <td>
                    <input type="number" class="form-control text-end harga" name="harga[]">
                </td>

                <td>
                    <input type="text" class="form-control text-end bg-light total" readonly>
                </td>

                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm btn-delete">
                        ×
                    </button>
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
