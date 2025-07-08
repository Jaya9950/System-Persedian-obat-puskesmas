<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penerimaan Barang</title>
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
        <h4 class="text-center">Laporan Penerimaan Barang</h4>
        <p><strong>Tanggal:</strong> {{ $data->tanggal_penerimaan }}</p>
    </div>

    <table style="margin-bottom: 20px;">
        <tr>
            <td style="width: 25%"><strong>Distributor</strong></td>
            <td>{{ $data->distributor }}</td>
        </tr>
        <tr>
            <td><strong>Nomor Faktur</strong></td>
            <td>{{ $data->nomor_faktur }}</td>
        </tr>
        <tr>
            <td><strong>Petugas Penerima</strong></td>
            <td>{{ $data->petugas_penerima }}</td>
        </tr>
    </table>

        <table cellspacing="0" cellpadding="5" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Qty</th>
                    <th>Satuan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data->items as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->nama_produk }}</td>
                    <td>{{ is_numeric($item->qty) ? number_format($item->qty) : '-' }}</td>
                    <td>{{ $item->sat ?? '-' }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="3" class="text-bold">Total Pengiriman</td>
                    <td class="text-bold">{{ number_format($data->total) }}</td>
                </tr>
            </tbody>
        </table>
    </body>
</html>