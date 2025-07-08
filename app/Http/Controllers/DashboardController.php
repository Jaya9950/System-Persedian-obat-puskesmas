<?php

namespace App\Http\Controllers;

use App\Models\PengeluaranBarang;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {

        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        $totalUsers = User::count();
        $totalProduk = Product::count();

        return view('dashboard.index', compact('totalUsers', 'totalProduk'));
    }
}
