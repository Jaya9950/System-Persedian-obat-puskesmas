<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pengeluaran Barang</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        .header { margin-bottom: 20px; }
        .text-center { text-align: center; }
        .text-bold { font-weight: bold; }
    </style>
</head>
<body>

    <div class="header">
        <h3 class="text-center">Puskesmas Maur Lama</h3>
        <h4 class="text-center">Laporan Pengeluaran Barang</h4>
    </div>

    <table cellspacing="0" cellpadding="5" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor</th>
                <th>Tanggal</th>
                <th>Nama Produk</th>
                <th>Qty</th>
                <th>Sat</th>
                <th>Permintaan</th>
                <th>Petugas</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach ($pengeluaranBarang as $pengeluaran)
                @foreach ($pengeluaran->items as $item)
                    <tr>
                        <td class="text-center">{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                        <td>{{ $pengeluaran->nomor_pengeluaran }}</td>
                        <td>{{ $pengeluaran->created_at->format('d-m-Y') }}</td>
                        <td>{{ $item->nama_produk ?? '-' }}</td>
                        <td>{{ is_numeric($item->qty) ? number_format($item->qty) : '-' }}</td>
                        <td>{{ $item->sat ?? '-' }}</td>
                        <td>{{ $pengeluaran->permintaan ?? '-' }}</td>
                        <td>{{ $pengeluaran->user->name ?? '-' }}</td>
                    </tr>
                    @php $total += $item->qty; @endphp
                @endforeach
            @endforeach
            <tr>
                <td colspan="4" class="text-bold text-center">Total Pengeluaran</td>
                <td class="text-bold">{{ number_format($total) }}</td>
                <td colspan="3"></td>
            </tr>
        </tbody>
    </table>

</body>
</html>