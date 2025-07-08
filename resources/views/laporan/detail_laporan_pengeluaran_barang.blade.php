@extends('layouts.app')

@section('content_title', 'Laporan Pengeluaran Barang')

@section('content')
<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="m-0">Laporan Pengeluaran Barang</h4>

        <!-- Tombol Export dengan Icon Print -->
        <div class="dropdown" style="margin-right: 1px;">
            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-print me-1"></i> Print
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="{{ route('laporan.pengeluaran-barang.detail.export.pdf', $pengeluaran->nomor_pengeluaran) }}">
                        <i class="fas fa-file-pdf text-danger me-2"></i> PDF
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('laporan.pengeluaran-barang.detail.export.excel', $pengeluaran->nomor_pengeluaran) }}">
                        <i class="fas fa-file-excel text-success me-2"></i> Excel
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center p-3">
        <div>
            <h3 class="h3">Puskesmas Maur Lama</h3>
            <h4 class="h6">Laporan Pengeluaran Barang</h4>
        </div>
        <div>
            <small class="text-muted">{{ $pengeluaran->created_at->format('Y-m-d') }}</small>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-4">
                <div class="d-flex align-content-center">
                    <h6 class="text-bold w-50">Nomor Pengeluaran</h6>
                    <p>{{ $pengeluaran->nomor_pengeluaran }}</p>
                </div>
                <div class="d-flex align-content-center">
                    <h6 class="text-bold w-50">Permintaan</h6>
                    <p>{{ $pengeluaran->permintaan }}</p>
                </div>
            </div>
            <div class="col-4">
                <div class="d-flex align-content-center">
                    <h6 class="text-bold w-50">Petugas</h6>
                    <p>{{ $pengeluaran->user->name ?? 'Admin' }}</p>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 20px">No</th>
                        <th>Nama Obat</th>
                        <th>Qty</th>
                        <th>Sat</th>
                        <th>Permintaan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengeluaran->items as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item->nama_produk }}</td>
                            <td>{{ number_format($item->qty) }}</td>
                            <td>{{ $item->product->sat ?? '-' }}</td>
                            <td>{{ $pengeluaran->permintaan ?? '-' }}</td>
                        </tr>
                        @endforeach
                    <tr>
                        <td colspan="3" class="text-bold text-end">Total Pengeluaran</td>
                        <td class="text-bold">{{ number_format($pengeluaran->items->sum('qty')) }}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Tombol Kembali (tidak diubah) -->
        <a href="{{ route('laporan.pengeluaran-barang.laporan') }}" class="btn btn-secondary mt-3">Kembali ke Laporan</a>
    </div>
</div>
@endsection