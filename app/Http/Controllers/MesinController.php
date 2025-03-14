<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mesin;
use Illuminate\Http\Request;

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
        return view('admin.mesin.create');
    }

    // Simpan data mesin baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'tahun' => 'required|integer',
            'deskripsi' => 'nullable|string',
        ]);

        Mesin::create($request->all());
        // Redirect ke halaman daftar mesin setelah tambah data berhasil
        return redirect()->route('mesin')->with('success', 'Data mesin berhasil ditambahkan!');
    }

    // Tampilkan form edit data mesin
    public function edit($id)
    {
        $mesin = Mesin::findOrFail($id);
        return view('admin.mesin.edit', compact('mesin'));
    }

    // Update data mesin
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'tahun' => 'required|integer',
            'deskripsi' => 'nullable|string',
        ]);

        $mesin = Mesin::findOrFail($id);
        $mesin->update($request->all());
        // Redirect ke halaman daftar mesin setelah update berhasil
        return redirect()->route('mesin')->with('success', 'Data mesin berhasil diperbarui!');
    }

    // Hapus data mesin
    public function destroy($id)
    {
        $mesin = Mesin::findOrFail($id);
        $mesin->delete();
        // Redirect ke halaman daftar mesin setelah hapus berhasil
        return redirect()->route('mesin')->with('success', 'Data mesin berhasil dihapus!');
    }
}
