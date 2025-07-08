<!DOCTYPE html>
<html>
<head>
    <style>
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid black; padding: 5px; }
    </style>
</head>
<body>
    <h3 style="text-align: center;">Laporan Pengeluaran Barang</h3>
    <table>
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
                        <td>{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                        <td>{{ $pengeluaran->nomor_pengeluaran }}</td>
                        <td>{{ $pengeluaran->created_at->format('d-m-Y') }}</td>
                        <td>{{ $item->nama_produk ?? '-' }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>{{ $item->sat }}</td>
                        <td>{{ $pengeluaran->permintaan }}</td>
                        <td>{{ $pengeluaran->user->name ?? '-' }}</td>
                    </tr>
                    @php $total += $item->qty; @endphp
                @endforeach
            @endforeach
            <tr>
                <td colspan="4"><strong>Total Pengeluaran</strong></td>
                <td><strong>{{ $total }}</strong></td>
                <td colspan="3"></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
