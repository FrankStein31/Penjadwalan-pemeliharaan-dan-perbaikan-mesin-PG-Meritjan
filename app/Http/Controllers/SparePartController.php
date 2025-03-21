<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SparePart;

class SparePartController extends Controller
{
    // Menampilkan semua spare part
    public function index()
    {
        $spareParts = SparePart::all();
        return view('admin.spare_part.index', compact('spareParts'));
    }

    // Menampilkan form tambah spare part
    public function create()
    {
        return view('admin.spare_part.create');
    }

    // Menyimpan spare part baru ke database
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kode_part' => 'required|string|max:50|unique:spare_parts,kode_part',
            'nama' => 'required|string|max:255',
            'jenis' => 'required|in:mekanik,elektrik,lainnya', // Validasi jenis
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        SparePart::create($validatedData);

        return redirect()->route('spare_part')->with('success', 'Spare part berhasil ditambahkan.');
    }

    // Menampilkan form edit spare part
    public function edit($id)
    {
        $sparePart = SparePart::findOrFail($id);
        return view('admin.spare_part.edit', compact('sparePart'));
    }

    // Memperbarui data spare part
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'kode_part' => 'required|string|max:50|unique:spare_parts,kode_part,' . $id,
            'nama' => 'required|string|max:255',
            'jenis' => 'required|in:mekanik,elektrik,lainnya', // Validasi jenis
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        $sparePart = SparePart::findOrFail($id);
        $sparePart->update($validatedData);

        return redirect()->route('spare_part')->with('success', 'Spare part berhasil diperbarui.');
    }

    // Menghapus spare part
    public function destroy($id)
    {
        $sparePart = SparePart::findOrFail($id);
        $sparePart->delete();

        return redirect()->route('spare_part')->with('success', 'Spare part berhasil dihapus.');
    }
}
