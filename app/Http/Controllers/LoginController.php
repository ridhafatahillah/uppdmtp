<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function Login()
    {
        return view('login', [
            'judul' => 'Login'
        ]);
    }
    public function postLogin(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);
        $dataa = [
            'name' => $request->name,
            'password' => $request->password
        ];

        if (Auth::attempt($dataa)) {
            // $request->session()->regenerate();
            return redirect('');
        } else {
            return redirect('login')->with('error', 'Username atau Password salah');
        }
    }

    public function register()
    {
        return view('register', [
            'judul' => 'Register'
        ]);
    }

    public function postRegister(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required',
            'email' => 'required'
        ]);
        $hashedPassword = bcrypt($request->password);
        $dataa = [
            'name' => $request->name,
            'password' => $hashedPassword,
            'email' => $request->email
        ];
        $user = User::create($dataa);
        if ($user) {
            return redirect('login')->with('success', 'Register Berhasil');
        } else {
            return redirect('register')->with('error', 'Register Gagal');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }
}
