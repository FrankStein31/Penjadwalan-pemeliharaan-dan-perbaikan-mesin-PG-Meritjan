<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register()
    {
        return view('auth/register');
    }

    public function registerSimpan(Request $request)
    {
        Validator::make($request->all(), [
            'nip' => 'required',
            'nama' => 'required',
            'password' => 'required|confirmed'

        ])->validate();

        User::create([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'password' => Hash::make($request->password),
            'level' => 'administrator'
        ]);

        return redirect()->route('login');
    }

    public function login()
    {
        return view('Auth.login');
    }

    public function loginAksi(Request $request)
    {
        Validator::make($request->all(), [
            'user_id' => 'required',
            'password' => 'required'
        ])->validate();

        if (!Auth::attempt($request->only('user_id', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed')
            ]);
        }

        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        return redirect('/');
    }
}
