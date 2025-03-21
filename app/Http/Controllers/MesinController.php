<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mesin;
use App\Models\SparePart;
use App\Models\Station;

class MesinController extends Controller
{
    // Tampilkan semua data mesin
    public function index()
    {
        $mesins = Mesin::all();
        return view('admin.mesin.index', compact('mesins'));
    }

    // Tampilkan form tambah data mesin
    public function create()
    {
        $stations = Station::all();
        return view('admin.mesin.create', compact('stations'));
    }

    // Simpan data mesin baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jenis' => 'required',
            'tahun' => 'required|numeric',
            'station_id' => 'nullable|exists:stations,id',
        ]);

        Mesin::create($request->all());
        return redirect()->route('mesin.index')->with('success', 'Mesin berhasil ditambahkan');
    }

    // Tampilkan form edit data mesin
    public function edit($id)
    {
        $mesin = Mesin::findOrFail($id);
        $stations = Station::all();
        return view('admin.mesin.edit', compact('mesin', 'stations'));
    }

    // Update data mesin
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'jenis' => 'required',
            'tahun' => 'required|numeric',
            'station_id' => 'nullable|exists:stations,id',
        ]);

        $mesin = Mesin::findOrFail($id);
        $mesin->update($request->all());
        return redirect()->route('mesin.index')->with('success', 'Mesin berhasil diperbarui');
    }

    // Hapus data mesin
    public function destroy($id)
    {
        $mesin = Mesin::findOrFail($id);
        $mesin->delete();
        return redirect()->route('mesin.index')->with('success', 'Data mesin berhasil dihapus!');
    }

    // Tampilkan detail mesin beserta spare part yang digunakan
    public function show($id)
    {
        $mesin = Mesin::with('spareParts')->findOrFail($id);
        $spareParts = SparePart::all();

        return view('admin.mesin.show', compact('mesin', 'spareParts'));
    }

    // Tambahkan spare part ke mesin
    public function addSparePart(Request $request, $id)
    {
        $mesin = Mesin::findOrFail($id);
        $mesin->spareParts()->attach($request->spare_part_id, ['jumlah' => $request->jumlah]);

        return redirect()->route('mesin.show', $id)->with('success', 'Spare part berhasil ditambahkan!');
    }

    // Perbarui jumlah spare part yang digunakan oleh mesin
    public function updateSparePart(Request $request, $mesin_id, $spare_part_id)
    {
        $mesin = Mesin::findOrFail($mesin_id);
        $mesin->spareParts()->updateExistingPivot($spare_part_id, ['jumlah' => $request->jumlah]);

        return redirect()->route('mesin.show', $mesin_id)->with('success', 'Jumlah spare part diperbarui!');
    }

    // Hapus spare part dari mesin
    public function removeSparePart($mesin_id, $spare_part_id)
    {
        $mesin = Mesin::findOrFail($mesin_id);
        $mesin->spareParts()->detach($spare_part_id);

        return redirect()->route('mesin.show', $mesin_id)->with('success', 'Spare part dihapus dari mesin!');
    }
}
