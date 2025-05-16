<?php

namespace App\Http\Controllers;

use App\Models\PascaGiling;
use App\Models\Mesin;
use App\Models\Station;
use Illuminate\Http\Request;

class PascaGilingController extends Controller
{
    // Tampilkan daftar jadwal pasca giling
    public function index()
    {
        $pascaGilings = PascaGiling::with(['station', 'mesin'])->get();
        return view('admin.pasca_giling.index', compact('pascaGilings'));
    }

    // Form tambah jadwal pasca giling
    public function create()
    {
        $stations = Station::all();
        $mesins = Mesin::all();
        return view('admin.pasca_giling.create', compact('stations', 'mesins'));
    }

    // Simpan jadwal pasca giling baru
    public function store(Request $request)
    {
        $request->validate([
            'station_id' => 'required|exists:stations,id',
            'mesin_id' => 'required|exists:mesins,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:Terjadwal,Selesai,Dibatalkan',
        ]);

        PascaGiling::create($request->all());

        return redirect()->route('pasca-giling.index')->with('success', 'Jadwal pasca giling berhasil ditambahkan.');
    }

    // Form edit jadwal pasca giling
    public function edit($id)
    {
        $jadwal = PascaGiling::findOrFail($id);
        $stations = Station::all();
        $mesins = Mesin::all();
        return view('admin.pasca_giling.edit', compact('jadwal', 'stations', 'mesins'));
    }

    // Update jadwal pasca giling
    public function update(Request $request, $id)
    {
        $request->validate([
            'station_id' => 'required|exists:stations,id',
            'mesin_id' => 'required|exists:mesins,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:Terjadwal,Selesai,Dibatalkan',
        ]);

        $jadwal = PascaGiling::findOrFail($id);
        $jadwal->update($request->all());

        return redirect()->route('pasca-giling.index')->with('success', 'Jadwal pasca giling berhasil diupdate.');
    }

    // Hapus jadwal pasca giling
    public function destroy($id)
    {
        $jadwal = PascaGiling::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('pasca-giling.index')->with('success', 'Jadwal pasca giling berhasil dihapus.');
    }
}
