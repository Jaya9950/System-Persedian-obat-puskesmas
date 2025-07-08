<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return view('Auth.login');
    }

    public function handleLogin(Request $request) 
    {
        $credentials = $request->validate([
            'email'     => 'required|email',
            'password'  => 'required',
        ],[
            'email.required' => 'Email Harus Di Isi',
            'email.email' => 'Email Tidak Valid',
            'password.required' => 'Password Harus Di Isi',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard'); // ganti ini sesuai route dashboard kamu
        }

        return back()->withErrors([
            'email' => 'Kredential yang anda masukkan tidak sesuai dengan data kami',
        ])->onlyInput('email');
    }

    public function logout(Request $request){

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
