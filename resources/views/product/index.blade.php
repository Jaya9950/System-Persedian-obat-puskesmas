@extends('layouts.app')
@section('content_title', 'Data Produk')
@section('content')

<div class="card">
    <div class="p-2 d-flex justify-content-between border">
        <h4 class="h5">Data Product</h4>
        <div>
            <x-product.form-product/>
        </div>
    </div>
    <div class="card-body">
        <x-alert :errors="$errors" />
            <div class="scrollable-table">
                <table class="table table-sm table-bordered table-striped" id="table2">
            <thead>
                <tr>
                    <th>No</th>
                    <th>SKU</th>
                    <th>Nama Obat</th>
                    <th>Sat</th>
                    <th>Stok Awal</th>
                    <th>Penerimaan</th>
                    <th>Persediaan</th>
                    <th>Pemakaian</th>
                    <th>Sisa Stok</th>
                    <th>Permintaan</th>
                    <th>Pemberian</th>
                    <th>Ket</th>
                    <th>Aktif</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $index => $product)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $product->sku }}</td>
                        <td>{{ $product->nama_obat }}</td>
                        <td>{{ $product->sat }}</td> <!-- STRING -->
                        <td>{{ is_numeric($product->stok_awal) ? number_format($product->stok_awal) : $product->stok_awal }}</td>
                        <td>{{ is_numeric($product->penerimaan) ? number_format($product->penerimaan) : $product->penerimaan }}</td>
                        <td>{{ is_numeric($product->persediaan) ? number_format($product->persediaan) : $product->persediaan }}</td>
                        <td>{{ $product->pemakaian }}</td> <!-- STRING -->
                        <td>{{ is_numeric($product->sisa_stok) ? number_format($product->sisa_stok) : $product->sisa_stok }}</td>
                        <td>{{ is_numeric($product->permintaan) ? number_format($product->permintaan) : $product->permintaan }}</td>
                        <td>{{ is_numeric($product->pemberian) ? number_format($product->pemberian) : $product->pemberian }}</td>
                        <td>{{ $product->ket }}</td> <!-- STRING -->
                        <td>
                            <p class="badge {{ $product->is_active ? 'badge-success' : 'badge-danger' }}">
                                {{ $product->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </p>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <x-product.form-product :id="$product->id" />
                                    <a href="{{ route('data-obat.product.destroy', $product->id) }}" class="btn btn-danger mx-1" data-confirm-delete="true">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection