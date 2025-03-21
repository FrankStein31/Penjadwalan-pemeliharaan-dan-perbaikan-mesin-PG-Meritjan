<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeknisiMesin;
use App\Models\User;
use App\Models\Mesin;
use App\Models\Station;

class TeknisiMesinController extends Controller
{
    public function index()
    {
        $teknisiMesins = TeknisiMesin::with(['user', 'mesin.station'])->get();
        return view('admin.teknisi_mesin.index', compact('teknisiMesins'));
    }

    public function create()
    {
        $users = User::where('level', 'Teknisi')->get();
        $mesins = Mesin::with('station')->get();
        $stations = Station::all();
        return view('admin.teknisi_mesin.create', compact('users', 'mesins', 'stations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'mesin_id' => 'required|exists:mesins,id',
        ]);

        TeknisiMesin::create($request->all());

        return redirect()->route('teknisi_mesin.index')
            ->with('success', 'Teknisi Mesin berhasil ditambahkan');
    }

    public function edit($id)
    {
        $teknisiMesin = TeknisiMesin::findOrFail($id);
        $users = User::where('level', 'Teknisi')->get();
        $mesins = Mesin::with('station')->get();
        $stations = Station::all();
        return view('admin.teknisi_mesin.edit', compact('teknisiMesin', 'users', 'mesins', 'stations'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'mesin_id' => 'required|exists:mesins,id',
        ]);

        $teknisiMesin = TeknisiMesin::findOrFail($id);
        $teknisiMesin->update($request->all());

        return redirect()->route('teknisi_mesin.index')
            ->with('success', 'Teknisi Mesin berhasil diperbarui');
    }

    public function destroy($id)
    {
        TeknisiMesin::findOrFail($id)->delete();
        return redirect()->route('teknisi_mesin.index')
            ->with('success', 'Teknisi Mesin berhasil dihapus');
    }
}
