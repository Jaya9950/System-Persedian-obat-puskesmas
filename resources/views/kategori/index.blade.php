@extends('layouts.app')
@section('content_title', 'Data Kategori')
@section('content')

<div class="card">
    <div class="p-2 d-flex justify-content-between border">
        <h4 class="h5">Data Kategori</h4>
        <div>
            <x-kategori.form-kategori />
        </div>
    </div>
    <div class="card-body">
        @if ($errors->all())
        <div class="alert alert-danger d-flex flex-column">
            @foreach ($errors->all() as $error)
                <small class="text-white my-2">{{ $error }}</small>
            @endforeach
            </div>
        @endif
        <table class="table table-sm table-responsive" id="table2">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kategori as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->nama_kategori }}</td>
                        <td>{{ $item->deskripsi }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <x-kategori.form-kategori :id="$item->id" />
                                    <a href="{{ route('data-obat.kategori.destroy', $item->id) }}" class="btn btn-danger mx-1" data-confirm-delete="true">
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
@endsection