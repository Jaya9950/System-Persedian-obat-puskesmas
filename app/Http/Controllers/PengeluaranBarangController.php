<?php

namespace App\Http\Controllers;

use App\Exports\PengeluaranBarangExport;
use App\Models\Product;
use App\Models\ItemPengeluaranBarang;
use App\Models\PengeluaranBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class PengeluaranBarangController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'produk' => 'required|array|min:1',
            'produk.*.produk_id' => 'required|exists:products,id',
            'produk.*.qty' => 'required|numeric|min:1',
            'permintaan' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();
            $pengeluaran = PengeluaranBarang::create([
                'nomor_pengeluaran' => PengeluaranBarang::nomorPengeluaran(),
                'tanggal_pengeluaran' => now(),
                'permintaan' => $request->input('permintaan'),
                'user_id'   => Auth::id(),
            ]);

            foreach ($request->produk as $item) {
                $produk = Product::findOrFail($item['produk_id']);

                if ($produk->stok_awal < $item['qty']) {
                    throw new \Exception("Stok tidak cukup untuk produk: {$produk->nama_obat}");
                }

                // Simpan item pengeluaran
                ItemPengeluaranBarang::create([
                    'pengeluaran_barang_id' => $pengeluaran->id,
                    'product_id' => $produk->id,
                    'nama_produk' => $produk->nama_obat,
                    'qty' => $item['qty'],
                    'sat' => $produk->sat,
                ]);

                // Update kolom produk
                $produk->stok_awal -= $item['qty'];
                $produk->persediaan -= $item['qty'];
                $produk->pemakaian += $item['qty'];
                $produk->sisa_stok -= $item['qty'];
                $produk->save();
            }

            DB::commit();
            toast()->success('Data berhasil disimpan!');
            return redirect()->route('pengeluaran-barang.index');
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            toast()->error('Gagal menyimpan: ' . $e->getMessage());
            return back()->withInput();
        }
    }
    
        public function index()
    {

        $user = Auth::user();

        if ($user->role === 'supervisor') {
            $pengeluaranBarangs = PengeluaranBarang::with('items.product')
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $pengeluaranBarangs = PengeluaranBarang::with('items.product')
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('pengeluaran-barang.index', compact('pengeluaranBarangs'));
    }

    public function laporan()
    {
        
        $user = Auth::user();

        if ($user->role === 'supervisor') {
            $pengeluaranBarang = PengeluaranBarang::with(['items.product', 'user'])
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $pengeluaranBarang = PengeluaranBarang::with(['items.product', 'user'])
                ->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('laporan.pengeluaran_barang', compact('pengeluaranBarang'));
    }

    public function detailLaporan($nomor)
    {
        
        $user = Auth::user();

        $query = PengeluaranBarang::with('items.product')
            ->where('nomor_pengeluaran', $nomor);

        if ($user->role !== 'supervisor') {
            $query->where('user_id', $user->id);
        }

        $pengeluaran = $query->firstOrFail();

        return view('laporan.detail_laporan_pengeluaran_barang', compact('pengeluaran'));
    }

    public function exportPDF()
    {
        
        $user = Auth::user();

        $query = PengeluaranBarang::with(['items.product', 'user']);

        if ($user->role !== 'supervisor') {
            $query->where('user_id', $user->id);
        }

        $pengeluaranBarang = $query->orderBy('created_at', 'desc')->get();

        $pdf = Pdf::loadView('laporan.pdf_pengeluaran_barang', compact('pengeluaranBarang'));
        return $pdf->download('laporan_pengeluaran_barang.pdf');
    }

    public function exportExcel()
    {
        $user = Auth::user();

        $query = PengeluaranBarang::with('items', 'user');

        if ($user->role !== 'supervisor') {
            $query->where('user_id', $user->id);
        }

        $pengeluaranBarang = $query->get();

        return Excel::download(new PengeluaranBarangExport($pengeluaranBarang), 'laporan_pengeluaran.xlsx');
    }
}