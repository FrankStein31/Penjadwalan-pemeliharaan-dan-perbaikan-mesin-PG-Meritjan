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

        // Cari user berdasarkan NIP
        $user = User::where('user_id', $request->user_id)->first();

        // Cek apakah user ada dan password cocok
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'user_id' => trans('auth.failed'),
            ]);
        }

        // Cek status user (harus 1 = aktif)
        if ($user->status != 1) {
            throw ValidationException::withMessages([
                'user_id' => 'Akun Anda tidak aktif. Hubungi admin untuk aktivasi.',
            ]);
        }
        Auth::login($user);
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