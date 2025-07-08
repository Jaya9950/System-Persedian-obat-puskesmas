<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProductController extends Controller
{

    public function index()
        {
            $user = Auth::user();

            $produk = $user->role === 'supervisor'
                ? Product::all()
                : Product::where('user_id', $user->id)->get();

            return view('product.index', ['products' => $produk]);
        }

    public function store(Request $request)
    {
        $id = $request->id;
        $request->validate([
            'nama_obat'     => 'required|unique:products,nama_obat,' . $id,
            'sat'           => 'required|string|min:0',
            'stok_awal'     => 'required|numeric|min:0',
            'kategori_id'   => 'required|exists:kategoris,id',
            'penerimaan'    => 'required|numeric|min:0',
            'persediaan'    => 'required|numeric|min:0',
            'pemakaian'     => 'required|string|min:3',
            'sisa_stok'     => 'required|numeric|min:0',
            'permintaan'    => 'required|numeric|min:0',
            'pemberian'     => 'required|numeric|min:0',
            'ket'           => 'required|string|min:0',
        ], [
            'nama_obat.required'        => 'Nama obat harus diisi',
            'nama_obat.unique'          => 'Nama obat sudah ada',
            'sat.required'              => 'Sat harus diisi',
            'sat.numeric'               => 'Sat harus berupa angka',
            'sat.min'                   => 'Sat minimal 0',
            'stok_awal.required'        => 'Stok awal harus diisi',
            'stok_awal.numeric'         => 'Stok awal harus berupa angka',
            'stok_awal.min'             => 'Stok awal minimal 0',
            'kategori_id.required'      => 'Kategori harus diisi',
            'kategori_id.exists'        => 'Kategori tidak valid',
            'penerimaan.required'       => 'Penerimaan harus diisi',
            'penerimaan.numeric'        => 'Penerimaan harus berupa angka',
            'penerimaan.min'            => 'Penerimaan minimal 0',
            'persediaan.required'       => 'Persediaan harus diisi',
            'persediaan.numeric'        => 'Persediaan harus berupa angka',
            'persediaan.min'            => 'Persediaan minimal 0',
            'pemakaian.required'        => 'Pemakaian harus diisi',
            'pemakaian.min'             => 'Pemakaian minimal 0',
            'sisa_stok.required'        => 'Sisa stok harus diisi',
            'sisa_stok.numeric'         => 'Sisa stok harus berupa angka',
            'sisa_stok.min'             => 'Sisa stok minimal 0',
            'permintaan.required'       => 'Permintaan harus diisi',
            'permintaan.numeric'        => 'Permintaan harus berupa angka',
            'permintaan.min'            => 'Permintaan minimal 0',
            'pemberian.required'        => 'Pemberian harus diisi',
            'pemberian.numeric'         => 'Pemberian harus berupa angka',
            'pemberian.min'             => 'Pemberian minimal 0',
            'ket.required'              => 'Ket harus diisi',
            'ket.min'                   => 'Ket minimal 0',
        ]);

        $newRequest = [
            'id'    => $id,
            'nama_obat'     => $request->nama_obat,
            'sat'           => $request->sat,
            'stok_awal'     => $request->stok_awal,
            'kategori_id'   => $request->kategori_id,
            'penerimaan'    => $request->penerimaan,
            'persediaan'    => $request->persediaan,
            'pemakaian'     => $request->pemakaian,
            'sisa_stok'     => $request->sisa_stok,
            'permintaan'    => $request->permintaan,
            'pemberian'     => $request->pemberian,
            'ket'           => $request->ket,
            'is_active'     => $request->is_active ? true : false,
            'user_id'       => Auth::id(),
        ];

        if (!$id) {
            $newRequest['sku'] = Product::nomorSku();
        }

        Product::updateOrCreate(
            ['id' => $id],
            $newRequest
        );

        toast()->success('Data berhasil disimpan');
        return redirect()->route('data-obat.product.index');
    }

    public function destroy(string $id)
    {
        $product = Product::find($id);
        $product->delete();
        toast()->success('Data berhasil dihapus');
        return redirect()->route('data-obat.product.index');
    }

    public function getData()
    {
        $search = request()->query('search');
        $query = Product::query();

        if ($search) {
            $query->where('nama_obat', 'like', '%' . $search . '%');
        }

        $products = $query->where('user_id', Auth::id())->limit(10)->get();
        return response()->json($products);
    }

    public function cekStok_Awal()
    {
        $id = request()->query('id');
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['stok_awal' => 0]);
        }

        return response()->json($product->stok_awal);
    }
}