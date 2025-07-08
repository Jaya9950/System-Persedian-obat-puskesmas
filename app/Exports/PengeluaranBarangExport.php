<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PengeluaranBarangExport implements FromView
{
    protected $pengeluaranBarang;

    public function __construct($pengeluaranBarang)
    {
        $this->pengeluaranBarang = $pengeluaranBarang;
    }

    public function view(): View
    {
        return view('exports.pengeluaran_barang', [
            'pengeluaranBarang' => $this->pengeluaranBarang
        ]);
    }
}
