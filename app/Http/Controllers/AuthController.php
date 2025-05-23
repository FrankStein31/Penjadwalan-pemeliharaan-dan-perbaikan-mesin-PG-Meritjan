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

        // Perbaikan token API Fonnte
        $token = "RWQHVXjZJS2nuH698t7C"; // Ganti dengan token API Fonnte yang valid
        $target = "6287733560829";
        $data = "Nama : " . Auth::user()->nama . "\n- NIP : " . Auth::user()->nip . "\n- Tanggal : " . date('d-m-Y H:i:s');

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $target,
                'message' => $data,
            ),
            CURLOPT_HTTPHEADER => array(
                "Authorization: $token"
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

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
