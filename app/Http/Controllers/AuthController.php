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
        return view('auth.register');
    }

    public function registerSimpan(Request $request)
    {
        Validator::make($request->all(), [
            'user_id' => 'required|unique:users,user_id',
            'nama' => 'required',
            'password' => 'required|confirmed'
        ])->validate();

        User::create([
            'user_id' => $request->user_id,
            'nama' => $request->nama,
            'password' => Hash::make($request->password),
            'level' => 'Administrator', // bisa diganti dinamis
            'status' => 1,
        ]);

        return redirect()->route('login');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function loginAksi(Request $request)
    {
        Validator::make($request->all(), [
            'user_id' => 'required',
            'password' => 'required'
        ])->validate();

        $user = User::where('user_id', $request->user_id)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'user_id' => trans('auth.failed'),
            ]);
        }

        if ($user->status != 1) {
            throw ValidationException::withMessages([
                'user_id' => 'Akun Anda tidak aktif. Hubungi admin.',
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        // ✅ Redirect berdasarkan level user
        switch ($user->level) {
            case 'Administrator':
                return redirect()->route('dashboard');
            case 'Teknisi':
                return redirect()->route('dashboard'); // atau route khusus teknisi
            case 'Manajer Teknisi':
                return redirect()->route('dashboard'); // atau route manajer
            case 'Operator Mesin':
                return redirect()->route('laporan-insidental.index');
            default:
                return redirect()->route('dashboard');
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
