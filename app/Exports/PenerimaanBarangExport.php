<?php

namespace App\Exports;

use App\Models\PenerimaanBarang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PenerimaanBarangExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return PenerimaanBarang::select(
            'nomor_penerimaan',
            'nomor_faktur',
            'distributor',
            'created_at',
            'petugas_penerima'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Nomor Penerimaan',
            'Nomor Faktur',
            'Distributor',
            'Tanggal Masuk',
            'Petugas Penerima',
        ];
    }
}