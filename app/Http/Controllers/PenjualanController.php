<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePenjualanRequest;
use App\Http\Requests\UpdatePenjualanRequest;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
// use App\Models\PenjualanDetail;
use App\Models\ProdukModel;
use Illuminate\Http\Request;
// Remove this line if you are not using Auth::... in the file
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
// use Illuminate\Validation\ValidationException;
use Barryvdh\DomPDF\Facade\Pdf;
class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $penjualan = Penjualan::with('user')
        // ->when($search, function ($query, $search) {
        //     $query->where('no_invoice', 'like', "%{$search}%")
        //           ->orWhere('total', 'like', "%{$search}%")
        //           ->orWhereHas('user', function ($query) use ($search) {
        //               $query->where('name', 'like', "%{$search}%");
        //           });
        // })
        // ->latest()
        // ->paginate(5);
         $search = $request->input('search');
        $metode = $request->input('metode_pembayaran');
        $to = $request->input('to');
        $from = $request->input('from');

        $penjualan = Penjualan::with('user')
    ->when($search, function($query, $search) {
        $query->where('kode', 'like', "%{$search}%");
    })
    ->when($metode, function($query, $metode) {
        $query->where('metode_pembayaran', $metode);
    })
     ->when($from, function($query, $from){
        $query->whereDate('tanggal', '>='   , $from);
    })
     ->when($to, function($query, $to){
        $query->whereDate('tanggal', '<='   , $to);
    })

    ->latest()->paginate(5);
        $penjualanDetail = PenjualanDetail::all();


        return view('penjualan.index', compact('penjualan', 'search', 'metode', 'to', 'from'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tanggal = date('Ymd');
    $jumlahHariIni = Penjualan::whereDate('created_at', today())->count();
    $urutan = str_pad($jumlahHariIni + 1, 3, '0', STR_PAD_LEFT);
    $kode = 'TRX' . $tanggal . $urutan;

    $produk = ProdukModel::all(); // ambil semua produk

    return view('penjualan.add', compact('kode', 'produk'));
    }

    /**
     * Store a newly created resource in storage.
     */
  public function store(StorePenjualanRequest $request)
{
    DB::transaction(function () use ($request) {

        $produkIds = $request->input('produk_id', []);
        $qtys = $request->input('qty', []);
        $total = 0;

        foreach ($produkIds as $i => $id) {

            if (!$id) continue;

            $produk = ProdukModel::lockForUpdate()->findOrFail($id);
            $qty = $qtys[$i] ?? 0;

            // ✅ VALIDASI STOK
            if ($qty > $produk->stok) {
         session()->flash('warning',
        "Stok {$produk->nama_barang} minus {$produk->stok} segera lakukan input stok agar tidak lupa");
}

        }

        // ✅ kalau lolos validasi baru buat penjualan
        $penjualan = Penjualan::create([
            'kode' => $request->kode,
            'tanggal' => $request->tanggal,
            'total' => 0,
            'dibayar' => $request->dibayar,
            'metode_pembayaran' => $request->metode_pembayaran,
            'user_id' => auth()->id(),
        ]);
              if ($request->dibayar < $total) {
    return back()
        ->withErrors(['dibayar' => 'Uang dibayar kurang.'])
        ->withInput();
}

        foreach ($produkIds as $i => $id) {

            if (!$id) continue;

            $produk = ProdukModel::lockForUpdate()->findOrFail($id);
            $qty = $qtys[$i] ?? 0;

            $harga = $produk->harga;
            $subtotal = $harga * $qty;
            $total += $subtotal;

            PenjualanDetail::create([
                'penjualan_id' => $penjualan->id,
                'produk_id' => $id,
                'qty' => $qty,
                'harga' => $harga,
                'subtotal' => $subtotal,
            ]);

            $produk->decrement('stok', $qty);
        }

        $penjualan->update([
            'total' => $total
        ]);
    });

    return redirect()->route('penjualan')
        ->with('success', 'Transaksi Berhasil');
}


    /**
     * Display the specified resource.
     */
        public function show(string $id)
    {
        $penjualan = Penjualan::findOrFail($id);   // data penjualan yang mau diupdate
        $produk = ProdukModel::all();                     // semua produk untuk dropdown
        $oldProduk = $penjualan->produk_id;
        $detailPenjualan = $penjualan->penjualan_detail;        // produk yang dipilih saat ini
        $grandTotal = $penjualan->total;
        return view('penjualan.update', compact('penjualan', 'produk', 'oldProduk', 'detailPenjualan','grandTotal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePenjualanRequest $request, string $id)
{
    DB::transaction(function () use ($request, $id) {

        // Ambil penjualan yang ingin diupdate
        $penjualan = Penjualan::findOrFail($id);
        $produkIds = $request->input('produk_id', []);
        $qtys = $request->input('qty', []);
        $total = 0;

        // 1️⃣ Kembalikan stok dari detail lama
        foreach ($penjualan->penjualan_detail as $detail) {
            $produk = ProdukModel::lockForUpdate()->findOrFail($detail->produk_id);
            $produk->increment('stok', $detail->qty); // kembalikan stok lama
        }

        // 2️⃣ Hapus detail lama
        $penjualan->penjualan_detail()->delete();

        // 3️⃣ Validasi stok baru
        foreach ($produkIds as $i => $produkId) {
            if (!$produkId) continue;

            $produk = ProdukModel::lockForUpdate()->findOrFail($produkId);
            $qty = $qtys[$i] ?? 0;

           if ($qty > $produk->stok) {
         session()->flash('warning',
        "Stok {$produk->nama_barang} minus {$produk->stok} segera lakukan input stok agar tidak lupa");
}
        }

        // 4️⃣ Update data penjualan
        $penjualan->update([
            'kode' => $request->kode,
            'tanggal' => $request->tanggal,
            'dibayar' => $request->dibayar,
            'metode_pembayaran' => $request->metode_pembayaran,
            'user_id' => auth()->id(),
            'total' => 0, // sementara, nanti diupdate
        ]);

        if ($request->dibayar < $total) {
            return back()->withErrors(['dibayar' => 'Uang dibayar kurang.'])->withInput();
        }

        // 5️⃣ Buat detail baru dan update stok
        foreach ($produkIds as $i => $produkId) {
            if (!$produkId) continue;

            $produk = ProdukModel::lockForUpdate()->findOrFail($produkId);
            $qty = $qtys[$i] ?? 0;
            $harga = $produk->harga;
            $subtotal = $harga * $qty;
            $total += $subtotal;

            PenjualanDetail::create([
                'penjualan_id' => $penjualan->id,
                'produk_id' => $produkId,
                'qty' => $qty,
                'harga' => $harga,
                'subtotal' => $subtotal,
            ]);

            $produk->decrement('stok', $qty); // kurangi stok sesuai qty baru
        }

        // 6️⃣ Update total
        $penjualan->update(['total' => $total]);
    });

    return redirect()->route('penjualan')->with('success', 'Transaksi Berhasil');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function cancel($id)
{
    DB::transaction(function () use ($id) {

        $penjualan = Penjualan::with('penjualan_detail')->findOrFail($id);

        // ❌ Cegah cancel dua kali
        if ($penjualan->status === 'DIBATALKAN') {
            throw new \Exception('Transaksi sudah dibatalkan.');
        }

        // 1️⃣ Kembalikan stok
        foreach ($penjualan->penjualan_detail as $detail) {

            $produk = ProdukModel::lockForUpdate()
                        ->find($detail->produk_id);

            if ($produk) {
                $produk->increment('stok', $detail->qty);
            }
        }

        // 2️⃣ Ubah status
        $penjualan->update([
            'status' => 'DIBATALKAN'
        ]);
    });

    return redirect()->route('penjualan')
        ->with('success', 'Transaksi berhasil dibatalkan dan stok dikembalikan.');
}

    public function detail(string $id)
    {
        $penjualan = Penjualan::findOrFail($id);   // data penjualan yang mau diupdate
        $produk = ProdukModel::all();                     // semua produk untuk dropdown
        $oldProduk = $penjualan->produk_id;
        $detailPenjualan = $penjualan->penjualan_detail;        // produk yang dipilih saat ini
        $grandTotal = $penjualan->total;
        return view('penjualan.detail', compact('penjualan', 'produk', 'oldProduk', 'detailPenjualan','grandTotal'));
    }



    public function exportPdf(Request $request){
        $search = $request->input('search');
    $metode = $request->input('metode_pembayaran');
    $from   = $request->input('from');
    $to     = $request->input('to');

   $penjualan = Penjualan::with('user')
    ->when($search, fn($q) => $q->where('kode', 'like', "%{$search}%"))
    ->when($metode, fn($q) => $q->where('metode_pembayaran', $metode))
    ->when($from,   fn($q) => $q->whereDate('tanggal', '>=', $from))
    ->when($to,     fn($q) => $q->whereDate('tanggal', '<=', $to))
    ->latest()
    ->get();

    $grandTotal = $penjualan->where('status', 'BERHASIL')->sum('total');
    $pdf = Pdf::loadView('penjualan.pdf', compact('penjualan', 'from', 'to', 'grandTotal'))
              ->setPaper('a4', 'landscape');

    return $pdf->download('laporan-penjualan.pdf');
    }
}
