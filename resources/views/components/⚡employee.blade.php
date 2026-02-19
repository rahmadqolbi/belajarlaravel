<?php

use Livewire\Component;
use App\Models\ProdukModel;

new class extends Component
{
    public $items = [];
    public $produk;

    public function mount()
    {
        $this->produk = ProdukModel::all();

        $this->items = [
            [
                'barang' => '',
                'nama_barang' => '',
                'qty' => 0,
                'harga' => 0,
                'subtotal' => 0,
            ]
        ];
    }

    public function tambahBaris()
        {
            $this->items[] = [
                'barang' => '',
                'nama_barang' => '',
                'qty' => 0,
                'harga' => 0,
                'subtotal' => 0,
            ];
        }
        public function hapusBaris($index)
{
    unset($this->items[$index]);
    $this->items = array_values($this->items); // reset index
}

    public function updatedItems($value, $key)
    {
        [$index, $field] = explode('.', $key);

        if ($field === 'barang') {
            $produk = $this->produk->firstWhere('id', $value);

            if ($produk) {
                $this->items[$index]['nama_barang'] = $produk->nama_barang;
                $this->items[$index]['harga'] = $produk->harga; // kalau mau auto isi harga
            }
        }

        // Hitung subtotal otomatis
        if (in_array($field, ['qty', 'harga'])) {
            $qty = $this->items[$index]['qty'] ?? 0;
            $harga = $this->items[$index]['harga'] ?? 0;

            $this->items[$index]['subtotal'] = $qty * $harga;
        }
    }

};
?>


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
                 <tbody>
@foreach($items as $index => $item)
<tr wire:key="row-{{ $index }}">

    <td>
        <select class="form-control"
            wire:model="items.{{ $index }}.barang">
            <option value="">-- Pilih Barang --</option>
            @foreach ($produk as $pro)
                <option value="{{ $pro->id }}">
                    {{ $pro->nama_barang }}
                </option>
            @endforeach
        </select>
    </td>

    <td>
        <input type="number"
            class="form-control text-end"
            wire:model="items.{{ $index }}.qty">
    </td>

    <td>
        <input type="number"
            class="form-control text-end"
            wire:model="items.{{ $index }}.harga">
    </td>

    <td>
        <input type="text"
            class="form-control text-end bg-light"
            readonly
            value="{{ $item['subtotal'] }}">
    </td>

    <td class="text-center">
        <button type="button"
            class="btn btn-danger btn-sm"
            wire:click="hapusBaris({{ $index }})">
            ×
        </button>
    </td>

</tr>
@endforeach
</tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between">
                <button type="button"
                    class="btn btn-outline-primary btn-sm"
                    wire:click="tambahBaris">
                    + Tambah Baris
                </button>
                <button type="button"
    class="btn btn-success"
    wire:click="simpan">
    Simpan Transaksi
</button>

            </div>

        </div>
    </div>
</div>
