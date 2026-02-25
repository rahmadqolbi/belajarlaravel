<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #1e293b; }

        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; font-size: 16px; }
        .header p  { margin: 4px 0; font-size: 11px; color: #64748b; }

        .meta { margin-bottom: 14px; font-size: 11px; color: #475569; }

        table { width: 100%; border-collapse: collapse; }
        thead th {
            background: #1e3a8a;
            color: #fff;
            padding: 8px 10px;
            text-align: left;
            font-size: 11px;
        }
        tbody td {
            padding: 7px 10px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 11px;
        }
        tbody tr:nth-child(even) { background: #f8fafc; }

        .badge-berhasil  { color: #059669; font-weight: bold; }
        .badge-batal     { color: #dc2626; font-weight: bold; }
        .badge-cash      { color: #047857; }
        .badge-transfer  { color: #1d4ed8; }

        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 10px;
            color: #94a3b8;
        }

        .total-row {
            font-weight: bold;
            background: #eff6ff !important;
        }
        .total-row td { border-top: 2px solid #2563eb; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Laporan Penjualan</h2>
        <p>
            Periode:
            {{ $from ? \Carbon\Carbon::parse($from)->format('d M Y') : 'Semua' }}
            —
            {{ $to ? \Carbon\Carbon::parse($to)->format('d M Y') : 'Semua' }}
        </p>
    </div>

    <div class="meta">
        Dicetak pada: {{ \Carbon\Carbon::now()->format('d M Y, H:i') }} WIB &nbsp;|&nbsp;
        Total Data: {{ $penjualan->count() }} transaksi
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Tanggal</th>
                <th>User</th>
                <th>Metode</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penjualan as $i => $pen)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $pen->kode }}</td>
                <td>{{ $pen->tanggal->format('d M Y') }}</td>
                <td>{{ $pen->user->email ?? '-' }}</td>
                <td class="{{ $pen->metode_pembayaran === 'CASH' ? 'badge-cash' : 'badge-transfer' }}">
                    {{ $pen->metode_pembayaran }}
                </td>
                {{-- ✅ Ganti rupiah() dengan number_format langsung --}}
                <td>Rp {{ number_format($pen->total, 0, ',', '.') }}</td>
                <td class="{{ $pen->status === 'BERHASIL' ? 'badge-berhasil' : 'badge-batal' }}">
                    {{ $pen->status }}
                </td>
            </tr>
            @endforeach

            {{-- ✅ Grand Total pakai $penjualan->sum() bukan $pen->total --}}
           <tr class="total-row">
    <td colspan="5" style="text-align:right;">Grand Total</td>
    <td>Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
    <td></td>
</tr>
        </tbody>
    </table>

    <div class="footer">
        Laporan ini digenerate otomatis oleh sistem.
    </div>

</body>
</html>
