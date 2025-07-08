@extends('layouts.app')
@section('content_title', 'Laporan Pengeluaran Barang')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Laporan Pengeluaran Barang</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm table-bordered" id="table2">
                <thead class="bg-light">
                    <tr>
                        <th>No</th>
                        <th>Nomor Pengeluaran</th>
                        <th>Tanggal</th>
                        <th>Nama Produk</th>
                        <th>Qty</th>
                        <th>Sat</th>
                        <th>Permintaan</th>
                        <th>Petugas</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                        @forelse ($pengeluaranBarang as $pengeluaran)
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
                                    <td>
                                        <a href="{{ route('laporan.pengeluaran-barang.detail-laporan', $pengeluaran->nomor_pengeluaran) }}" class="btn btn-sm btn-primary">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">Tidak ada data pengeluaran barang.</td>
                            </tr>
                        @endforelse
                    @if ($pengeluaranBarang->count())
                        <tr>
                            <td colspan="4"><strong>Total Pengeluaran</strong></td>
                            <td><strong>{{ $total }}</strong></td>
                            <td colspan="4"></td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
