<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function show()
    {
        if (session('admin_logged_in')) {
            return redirect('/dashboard');
        }
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($request->username === 'admin123' && $request->password === 'rahasia123') {
            session(['admin_logged_in' => true]);
            return redirect('/dashboard');
        }

        return back()->withErrors(['error' => 'Username atau password salah.']);
    }

    public function logout()
    {
        session()->forget('admin_logged_in');
        return redirect('/');
    }
}
