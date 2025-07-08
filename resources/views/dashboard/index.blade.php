@extends('layouts.app')
@section('content_title', 'Dashboard')
@section('content')
<div class="row">
    <x-dashboard-card type="bg-info" icon="fas fa-users" label="Total Users" value="{{ $totalUsers }}" />
    <x-dashboard-card type="bg-success" icon="fas fa-suitcase" label="Total Produk" value="{{ $totalProduk }}" />
</div>
@endsection