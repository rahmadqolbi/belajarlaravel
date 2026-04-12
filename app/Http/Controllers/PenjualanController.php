<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePenjualanRequest;
use App\Http\Requests\UpdatePenjualanRequest;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
// use App\Models\PenjualanDetail;
use App\Models\ProdukModel;
use App\Models\StokOutlet;
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

    // Ambil produk berdasarkan outlet tertentu
    // Ganti $outletId sesuai kebutuhan — bisa dari session, auth, atau hardcode dulu

    $outletId = auth()->user()->outlet_id;

    $produk = StokOutlet::with('produk')
        ->where('outlet_id', $outletId)
        ->where('stok', '>', 0)
        ->get();

    // dd($produk);


    return view('penjualan.add', compact('kode', 'produk'));
}

    /**
     * Store a newly created resource in storage.
     */
 public function store(StorePenjualanRequest $request)
{

try{
   DB::transaction(function () use ($request) {

        $produkIds = $request->input('produk_id', []);
        $qtys      = $request->input('qty', []);
        $outletId  = auth()->user()->outlet_id; // ← outlet user yg login
        $total     = 0;

        // Validasi stok dulu sebelum simpan apapun
        foreach ($produkIds as $i => $id) {
            if (!$id) continue;

            $qty = $qtys[$i] ?? 0;

            $stokOutlet = StokOutlet::where('produk_id', $id)
                ->where('outlet_id', $outletId)
                ->first();

            $stokTersedia = $stokOutlet->stok ?? 0;

            if ($qty > $stokTersedia) {
                $produk = ProdukModel::find($id);
                throw new \Exception("Stok {$produk->nama_barang} tidak cukup! Tersedia: {$stokTersedia}");
            }
        }

        // Simpan header penjualan
        $penjualan = Penjualan::create([
            'kode'              => $request->kode,
            'tanggal'           => $request->tanggal,
            'total'             => 0,
            'dibayar'           => $request->dibayar,
            'metode_pembayaran' => $request->metode_pembayaran,
            'user_id'           => auth()->id(),
            'outlet_id'         => $outletId,
        ]);

        // Simpan detail + kurangi stok
        foreach ($produkIds as $i => $id) {
            if (!$id) continue;

            $qty      = $qtys[$i] ?? 0;
            $produk   = ProdukModel::find($id);
            $harga    = $produk->harga;
            $subtotal = $harga * $qty;
            $total   += $subtotal;

            PenjualanDetail::create([
                'penjualan_id' => $penjualan->id,
                'produk_id'    => $id,
                'qty'          => $qty,
                'harga'        => $harga,
                'subtotal'     => $subtotal,
            ]);

            // Kurangi stok dari stok_outlet
            StokOutlet::where('produk_id', $id)
                ->where('outlet_id', $outletId)
                ->decrement('stok', $qty);
        }

        $penjualan->update(['total' => $total]);
    });
}catch (\Exception $e) {
    return redirect()->back()
        ->with('error', $e->getMessage())
        ->withInput();
}


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
    $penjualan = Penjualan::with('penjualan_detail')->findOrFail($id);
    $produkIds = $request->input('produk_id', []);
    $qtys = $request->input('qty', []);

    // ✅ Hitung total dulu SEBELUM transaksi
    $total = 0;
    foreach ($produkIds as $i => $produkId) {
        if (!$produkId) continue;
        $produk = ProdukModel::findOrFail($produkId);
        $qty = $qtys[$i] ?? 0;
        $total += $produk->harga * $qty;
    }

    // ✅ Validasi dibayar di LUAR transaksi
    if ($request->dibayar < $total) {
        return back()
            ->withErrors(['dibayar' => 'Uang dibayar kurang.'])
            ->withInput();
    }

    DB::transaction(function () use ($request, $id, $produkIds, $qtys, $total) {

        $penjualan = Penjualan::findOrFail($id);

        // 1️⃣ Kembalikan stok lama
        foreach ($penjualan->penjualan_detail as $detail) {
            ProdukModel::lockForUpdate()->findOrFail($detail->produk_id)
                ->increment('stok', $detail->qty);
        }

        // 2️⃣ Hapus detail lama
        $penjualan->penjualan_detail()->delete();

        // 3️⃣ Update header penjualan
        $penjualan->update([
            'kode'               => $request->kode,
            'tanggal'            => $request->tanggal,
            'dibayar'            => $request->dibayar,
            'metode_pembayaran'  => $request->metode_pembayaran,
            'user_id'            => auth()->id(),
            'outlet'             => auth()->user(),
            'total'              => $total,
        ]);

        // 4️⃣ Buat detail baru & kurangi stok
        foreach ($produkIds as $i => $produkId) {
            if (!$produkId) continue;

            $produk = ProdukModel::lockForUpdate()->findOrFail($produkId);
            $qty    = $qtys[$i] ?? 0;
            $harga  = $produk->harga;

            if ($qty > $produk->stok) {
                session()->flash('warning',
                    "Stok {$produk->nama_barang} tersisa {$produk->stok}, segera lakukan input stok!");
            }

            PenjualanDetail::create([
                'penjualan_id' => $penjualan->id,
                'produk_id'    => $produkId,
                'qty'          => $qty,
                'harga'        => $harga,
                'subtotal'     => $harga * $qty,
            ]);

            $produk->decrement('stok', $qty);
        }
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

    StokOutlet::where('produk_id', $detail->produk_id)
        ->where('outlet_id', $penjualan->outlet_id)
        ->increment('stok', $detail->qty);
}



        // 2️⃣ Ubah status
        $penjualan->update([
            'status' => 'DIBATALKAN',
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
