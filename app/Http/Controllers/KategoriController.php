<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use function Pest\Laravel\delete;

class KategoriController extends Controller
{
    public function index() {

        $user = Auth::user();

        if ($user->role === 'supervisor') {
            $kategori = Kategori::all(); // bisa lihat semua
        } else {
            $kategori = Kategori::where('user_id', $user->id)->get(); // hanya data sendiri
        }

        confirmDelete('Hapus Data', 'Apakah anda yakin ingin menghapus data ini?');
        return view('kategori.index', compact('kategori'));
    }

    public function store(Request $request)
    {
        $id = $request->id;
        $request->validate([
            'nama_kategori' => 'required|unique:kategoris,nama_kategori,'.$id,
            'deskripsi'     => 'required|max:100|min:10'
        ],[
            'nama_kategori.required'    => 'Nama Kategori Harus Diisi',
            'nama_kategori.unique'      => 'Nama Kategori Sudah Ada',
            'deskripsi.required'        => 'Deskripsi Harus Diisi',
            'deskripsi.max'             => 'Deskripsi Miksimal 100 Karakter',
            'deskripsi.min'             => 'Deskripsi Minimal 10 Karakter',
        ]);

        $user = Auth::user();

        if ($id) {
            $kategori = Kategori::findOrFail($id);

            // hanya supervisor atau pemilik yang bisa update
            if ($user->role !== 'supervisor' && $kategori->user_id !== $user->id) {
                abort(403, 'Tidak diizinkan mengubah data ini');
            }

            $kategori->update([
                'nama_kategori' => $request->nama_kategori,
                'slug' => Str::slug($request->nama_kategori),
                'deskripsi' => $request->deskripsi,
            ]);
        } else {
            Kategori::create([
                'nama_kategori' => $request->nama_kategori,
                'slug' => Str::slug($request->nama_kategori),
                'deskripsi' => $request->deskripsi,
                'user_id' => $user->id,
            ]);
        }

        toast()->success('Data Berhasil Disimpan');
        return redirect()->route('data-obat.kategori.index');

    }

    public function destroy(String $id)
    {
        $kategori = Kategori::findOrFail($id);

        $user = Auth::user();
        if ($user->role !== 'supervisor' && $kategori->user_id !== $user->id) {
            abort(403, 'Tidak diizinkan menghapus data ini');
        }

        $kategori->delete();
        toast()->success('Data Berhasil Dihapus');
        return redirect()->route('data-obat.kategori.index');
    }
}
