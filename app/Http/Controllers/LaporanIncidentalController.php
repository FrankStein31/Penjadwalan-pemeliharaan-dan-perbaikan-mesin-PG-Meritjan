<?php

namespace App\Http\Controllers;

use App\Models\LaporanIncidental;
use App\Models\Mesin;
use App\Models\SparePart;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanIncidentalController extends Controller
{
    // Tampilkan semua laporan milik user login
    public function index()
    {
        $laporans = LaporanIncidental::with(['mesin', 'station'])->paginate(10);
        return view('laporan_incidental.index', compact('laporans'));
    }

    // Tampilkan form tambah laporan
    public function create()
    {
        $stations = Station::all();
        $mesins = Mesin::all();
        $spareParts = SparePart::all();

        return view('laporan_incidental.create', compact('stations', 'mesins', 'spareParts'));
    }


    // Simpan laporan insidental baru
    public function store(Request $request)
    {
        $request->validate([
            'mesin_id' => 'required|integer|exists:mesins,id',
            'station_id' => 'required|integer|exists:stations,id',
            'description' => 'required|string',
            'photo_path' => 'nullable|image|max:2048',
            'requires_spare_part' => 'nullable|boolean',
        ]);

        $path = $request->hasFile('photo_path')
            ? $request->file('photo_path')->store('laporan-insidental', 'public')
            : null;

        LaporanIncidental::create([

            'mesin_id' => $request->mesin_id,
            'station_id' => $request->station_id,
            'description' => $request->description,
            'photo_path' => $path,
            'requires_spare_part' => $request->requires_spare_part ?? false,
        ]);

        return redirect()->route('laporan-insidental.index')->with('success', 'Laporan insidental berhasil dikirim.');
    }

    // Lihat detail laporan
    public function show($id)
    {
        $laporan = LaporanIncidental::findOrFail($id);

        return view('laporan_incidental.show', compact('laporan'));
    }

    public function edit($id)
{
    $laporan = LaporanIncidental::findOrFail($id);
    $stations = Station::all();
    $mesins = Mesin::all();
    // Kalau perlu data lain, tambahkan di sini

    return view('laporan_incidental.edit', compact('laporan', 'stations', 'mesins'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'mesin_id' => 'required|integer|exists:mesins,id',
        'station_id' => 'required|integer|exists:stations,id',
        'description' => 'required|string',
        'photo_path' => 'nullable|image|max:2048',
        'requires_spare_part' => 'nullable|boolean',
    ]);

    $laporan = LaporanIncidental::findOrFail($id);

    if ($request->hasFile('photo_path')) {
        // Hapus foto lama jika ada
        if ($laporan->photo_path) {
            Storage::disk('public')->delete($laporan->photo_path);
        }
        $path = $request->file('photo_path')->store('laporan-insidental', 'public');
        $laporan->photo_path = $path;
    }

    $laporan->mesin_id = $request->mesin_id;
    $laporan->station_id = $request->station_id;
    $laporan->description = $request->description;
    $laporan->requires_spare_part = $request->requires_spare_part ?? false;

    $laporan->save();

    return redirect()->route('laporan-insidental.index')->with('success', 'Laporan berhasil diperbarui.');
}


    // Hapus laporan
    public function destroy($id)
    {
        $laporan = LaporanIncidental::findOrFail($id);

        // Hapus foto jika ada
        if ($laporan->photo_path) {
            Storage::disk('public')->delete($laporan->photo_path);
        }

        $laporan->delete();

        return redirect()->route('laporan-insidental.index')->with('success', 'Laporan berhasil dihapus.');
    }
}
