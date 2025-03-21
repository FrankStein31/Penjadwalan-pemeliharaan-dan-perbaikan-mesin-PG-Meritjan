<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mesin;
use App\Models\Station;
use Illuminate\Http\Request;

class MesinController extends Controller
{
    // Tampilkan semua data mesin
    public function index()
    {
        $mesins = Mesin::with('station')->get(); // Ambil mesin dengan data station
        return view('admin.mesin.index', compact('mesins'));
    }

    // Tampilkan form tambah data mesin
    public function create()
    {
        $stations = Station::all(); // Ambil semua station untuk dropdown
        return view('admin.mesin.create', compact('stations'));
    }

    // Simpan data mesin baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'tahun' => 'required|integer',
            'deskripsi' => 'nullable|string',
            'station_id' => 'required|exists:stations,id', // Validasi station_id
        ]);

        Mesin::create($request->all());

        return redirect()->route('mesin')->with('success', 'Data mesin berhasil ditambahkan!');
    }

    // Tampilkan form edit data mesin
    public function edit($id)
    {
        $mesin = Mesin::findOrFail($id);
        $stations = Station::all(); // Ambil semua station untuk dropdown
        return view('admin.mesin.edit', compact('mesin', 'stations'));
    }

    // Update data mesin
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'tahun' => 'required|integer',
            'deskripsi' => 'nullable|string',
            'station_id' => 'required|exists:stations,id',
        ]);

        $mesin = Mesin::findOrFail($id);
        $mesin->update($request->all());

        return redirect()->route('mesin')->with('success', 'Data mesin berhasil diperbarui!');
    }

    // Hapus data mesin
    public function destroy($id)
    {
        $mesin = Mesin::findOrFail($id);
        $mesin->delete();

        return redirect()->route('mesin')->with('success', 'Data mesin berhasil dihapus!');
    }
}
