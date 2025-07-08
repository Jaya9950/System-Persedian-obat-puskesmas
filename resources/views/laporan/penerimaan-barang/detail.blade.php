@extends('layouts.app')
@section('content_title', 'Laporan Penerimaan Barang')

@section('content')
<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="m-0">Laporan Penerimaan Barang</h4>

        <!-- Tombol Export dengan Icon Print -->
        <div class="dropdown" style="margin-right: 1px;">
            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-print me-1"></i> Print
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="{{ route('laporan.penerimaan-barang.detail.export.pdf', $data->nomor_penerimaan) }}">
                        <i class="fas fa-file-pdf text-danger me-2"></i> PDF
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('laporan.penerimaan-barang.detail.export.excel', $data->nomor_penerimaan) }}">
                        <i class="fas fa-file-excel text-success me-2"></i> Excel
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center p-3">
        <div>
            <h3 class="h3">Puskesmas Maur Lama</h3>
            <h4 class="h6">Laporan Penerimaan Barang</h4>
        </div>
        <div>
            <small class="text-muted">{{ $data->tanggal_penerimaan }}</small>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-4">
                <div class="d-flex align-content-center">
                    <h6 class="text-bold w-50">Nomor Penerimaan</h6>
                    <p>{{ $data->nomor_penerimaan }}</p>
                </div>
                <div class="d-flex align-content-center">
                    <h6 class="text-bold w-50">Distributor</h6>
                    <p>{{ $data->distributor }}</p>
                </div>
                <div class="d-flex align-content-center">
                    <h6 class="text-bold w-50">Nomor Faktur</h6>
                    <p>{{ $data->nomor_faktur }}</p>
                </div>
            </div>
            <div class="col-4">
                <div class="d-flex align-content-center">
                    <h6 class="text-bold w-50">Petugas Penerima</h6>
                    <p>{{ $data->petugas_penerima }}</p>
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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data->items as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item->nama_produk }}</td>
                        <td>{{ number_format($item->qty) }} <small>kapsul</small></td>
                        <td>{{ $item->sat }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" class="text-bold">Total Penerimaan</td>
                        <td class="text-bold">{{ number_format($data->total) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Tombol Kembali -->
        <a href="{{ route('laporan.penerimaan-barang.laporan') }}" class="btn btn-secondary mt-3">Kembali ke Laporan</a>
    </div>
</div>
@endsection
