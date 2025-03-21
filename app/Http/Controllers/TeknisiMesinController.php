<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TeknisiMesin;
use App\Models\User;
use App\Models\Mesin;

class TeknisiMesinController extends Controller
{
    public function index()
    {
        $teknisiMesin = TeknisiMesin::with('teknisi', 'mesin')->get();
        return view('admin.teknisi_mesin.index', compact('teknisiMesin'));
    }

    public function create()
    {
        $teknisi = User::where('level', 'Teknisi')->get();
        $mesin = Mesin::all();
        return view('admin.teknisi_mesin.create', compact('teknisi', 'mesin'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mesin_id' => 'required|exists:mesins,id',
            'user_id' => 'required|exists:users,id',
        ]);

        TeknisiMesin::create([
            'mesin_id' => $request->mesin_id,
            'user_id' => $request->user_id,
        ]);

        return redirect()->route('teknisi_mesin.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $teknisiMesin = TeknisiMesin::findOrFail($id);
        $teknisi = User::where('level', 'Teknisi')->get();
        $mesin = Mesin::all();
        return view('admin.teknisi_mesin.edit', compact('teknisiMesin', 'teknisi', 'mesin'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'mesin_id' => 'required|exists:mesins,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $teknisiMesin = TeknisiMesin::findOrFail($id);
        $teknisiMesin->update([
            'mesin_id' => $request->mesin_id,
            'user_id' => $request->user_id,
        ]);

        return redirect()->route('teknisi_mesin.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        TeknisiMesin::findOrFail($id)->delete();
        return redirect()->route('teknisi_mesin.index')->with('success', 'Data berhasil dihapus!');
    }
}
