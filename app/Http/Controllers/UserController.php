<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Station;
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
        $stations = Station::all();
        return view('users.tambah', compact('stations'));
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
            'station_id' => 'nullable|exists:stations,id',
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
            'station_id' => $request->station_id,
        ];

        User::create($data);

        Log::info('User created');

        return redirect()->route('users')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $stations = Station::all();
        return view('users.edit', compact('user', 'stations'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|unique:users,user_id',
            'nama' => 'required',
            'level' => 'required',
            'alamat' => 'required',
            'telp' => 'required',
            'status' => 'required',
            'station_id' => 'nullable|exists:stations,id',
        ]);

        $user = User::findOrFail($id);
        
        $user->user_id = $request->user_id;
        $user->nama = $request->nama;
        $user->level = $request->level;
        $user->alamat = $request->alamat;
        $user->telp = $request->telp;
        $user->station_id = $request->station_id;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users')->with('success', 'Data berhasil diupdate');
    }

    public function hapus($id)
    {
        User::find($id)->delete();
        return redirect()->route('users')->with('success', 'Data berhasil dihapus');
    }

    public function create()
    {
        $stations = Station::all();
        return view('admin.users.create', compact('stations'));
    }
}
