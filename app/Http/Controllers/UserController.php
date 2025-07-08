<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'supervisor') {
        abort(403, 'Anda tidak punya akses ke halaman ini');
        }

        $users = User::all();
        confirmDelete('Hapus User', 'Apakah anda yakin menghapus user ini?');
        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $id = $request->id;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:supervisor,perawat', // validasi role

        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return back()->with('success', 'User berhasil ditambahkan');

        toast()->success('User berhasil disimpan');
        return redirect()->route('users.index');
    }

    public function gantiPassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password'      => 'required|min:8|confirmed',
            // 'password'      => [Password::min(8)->mixedCase()->numbers()->symbols(), 'confirmed'],
        ], [
            'old_password.required' => 'Password lama harus diisi',
            'password.required'     => 'Password baru harus diisi',
            'password.min'          => 'Password baru min 8 karakter',
            'password.confirme'     => 'Password baru tidak sama dengan konfirmasi password'
        ]);

        $user = User::find(Auth::id());

        // check old password
        if (!Hash::check($request->old_password, $user->password)) {
            toast()->error('password lama tidak sesuai');
            return redirect()->route('dashboard');
        }

        // update password
        $user->update([
            'password'  => Hash::make($request->password)
        ]);

        toast()->success('Password berhasil diubah');
        return redirect()->route('dashboard');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:supervisor,perawat',
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
        ]);

        $user->update($validated);

        toast()->success('User berhasil diupdate');
        return redirect()->route('users.index');
    }

    public function destroy(string $id)
    {
        $user = User::find($id);

        if (Auth::id() == $id) {
            toast()->error('Tidak dapat menghapus akun yang sedang login');
            return redirect()->route('users.index');
        }

        $user->delete();
        toast()->success('User berhasil dihapus');
        return redirect()->route('users.index');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'id'    => 'required',
        ]);

        $user = User::find($request->id);
        $user->update([
            'password' => Hash::make('12345678')
        ]);
        toast()->success('Password berhasil direset');
        return redirect()->route('users.index');
    }
}