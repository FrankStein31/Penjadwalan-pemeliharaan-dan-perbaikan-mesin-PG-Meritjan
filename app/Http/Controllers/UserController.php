<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();
        return view('users.index', ['data' => $users]);
    }

    public function tambah()
    {
        return view('users.tambah');
    }

    public function simpan(Request $request)
    {
        Log::info('Simpan method accessed');

        $request->validate([
            'user_id' => 'required|unique:users,user_id',
            'nama' => 'required',
            'password' => 'required',
            'level' => 'required',
            'alamat' => 'required',
            'telp' => 'required',
            // 'rincian_pekerjaan' => 'nullable',
            'status' => 'required',
        ]);

        Log::info('Validation passed');

        $data = [
            'user_id' => $request->user_id,
            'nama' => $request->nama,
            'password' => Hash::make($request->password),
            'level' => $request->level,
            'alamat' => $request->alamat,
            'telp' => $request->telp,
            // 'rincian_pekerjaan' => $request->rincian_pekerjaan,
            'status' => $request->status,
        ];

        User::create($data);

        Log::info('User created');

        return redirect()->route('users')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $users = User::findOrFail($id);
        return view('users.edit', ['users' => $users]);
    }

    public function update($id, Request $request)
    {
        $data = [
            'user_id' => $request->user_id,
            'nama' => $request->nama,
            'level' => $request->level,
            'alamat' => $request->alamat,
            'telp' => $request->telp,
            // 'rincian_pekerjaan' => $request->rincian_pekerjaan,
            'status' => $request->status,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        User::find($id)->update($data);

        return redirect()->route('users')->with('success', 'Data berhasil diupdate');
    }

    public function hapus($id)
    {
        User::find($id)->delete();
        return redirect()->route('users')->with('success', 'Data berhasil dihapus');
    }
}
