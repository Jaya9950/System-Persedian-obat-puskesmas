<?php

namespace App\Http\Controllers;

use PDF;
use App\Exports\PenerimaanBarangExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PenerimaanBarang;
use App\Models\ItemPenerimaanBarang;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenerimaanBarangController extends Controller
{
    public function index()
    {
        return view('penerimaan-barang.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'distributor'   => 'required',
            'nomor_faktur'  => 'required',
            'produk'        => 'required|array',
        ], [
            'distributor.required'  => 'Distributor harus diisi',
            'nomor_faktur.required' => 'Nomor faktur harus diisi',
            'produk.required'       => 'Produk harus diisi',
        ]);

        try {
            DB::beginTransaction();

            // Simpan data utama penerimaan
            $penerimaan = PenerimaanBarang::create([
                'nomor_penerimaan' => PenerimaanBarang::nomorPenerimaan(),
                'distributor'      => $request->distributor,
                'nomor_faktur'     => $request->nomor_faktur,
                'petugas_penerima' => Auth::user()->name,
                'user_id'          => Auth::id(),
            ]);

            foreach ($request->produk as $item) {
                $produk = Product::find($item['produk_id']);

                if (!$produk) {
                    throw new \Exception("Produk dengan ID {$item['produk_id']} tidak ditemukan.");
                }

                // Simpan ke detail item penerimaan
                ItemPenerimaanBarang::create([
                    'nomor_penerimaan' => $penerimaan->nomor_penerimaan,
                    'nama_produk'      => $item['nama_obat'],
                    'qty'              => $item['qty'],
                    'sat'              => $produk->sat, // <- Tambahan kolom satuan
                ]);

                // ✅ Tambahkan qty ke stok_awal
                $produk->stok_awal += $item['qty'];

                // (Opsional) Update persediaan kalau kamu ingin logika ini juga
                $produk->persediaan = $produk->stok_awal + $produk->penerimaan;

                $produk->save();
            }

            DB::commit();

            toast()->success('Data berhasil ditambahkan');
            return redirect()->route('penerimaan-barang.index');
        } catch (\Exception $e) {
            DB::rollBack();

            report($e);
            toast()->error('Terjadi kesalahan saat menyimpan data!');
            return back()->withInput();
        }
    }

    public function laporan()
    {
        
        if (Auth::user()->role === 'supervisor') {
        $penerimaanBarang = PenerimaanBarang::orderBy('created_at', 'desc')->get();
        } else {
            $penerimaanBarang = PenerimaanBarang::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        }

        $penerimaanBarang = $penerimaanBarang->map(function ($item) {
            $item->tanggal_penerimaan = \Carbon\Carbon::parse($item->created_at)->locale('id')->translatedFormat('l, d F Y');
            return $item;
        });

        return view('laporan.penerimaan-barang.laporan', compact('penerimaanBarang'));
        }

    public function detailLaporan(String $nomorPenerimaan) {
        $query = PenerimaanBarang::with('items')->where('nomor_penerimaan', $nomorPenerimaan);

        if (Auth::user()->role !== 'supervisor') {
            $query->where('user_id', Auth::id());
        }

        $data = $query->firstOrFail();

        $data->tanggal_penerimaan = Carbon::parse($data->created_at)->locale('id')->translatedFormat('l, d F Y');
        $data->total = $data->items()->sum('qty');

        return view('laporan.penerimaan-barang.detail', compact('data'));
        }

   public function exportPDF($nomorPenerimaan)
    {
        $data = PenerimaanBarang::with('items')->where('nomor_penerimaan', $nomorPenerimaan)->firstOrFail();
        $data->tanggal_penerimaan = Carbon::parse($data->created_at)->locale('id')->translatedFormat('d F Y');
        $data->total = $data->items()->sum('qty');

        $pdf = FacadePdf::loadView('laporan.penerimaan-barang.export-pdf', compact('data'));
        return $pdf->download("penerimaan-{$nomorPenerimaan}.pdf");
    }

    public function exportExcel($nomorPenerimaan)
    {
        return Excel::download(new PenerimaanBarangExport($nomorPenerimaan), "penerimaan-{$nomorPenerimaan}.xlsx");
    }
}