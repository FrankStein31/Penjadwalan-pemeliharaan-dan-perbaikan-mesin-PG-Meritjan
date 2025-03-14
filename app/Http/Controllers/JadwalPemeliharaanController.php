<?php

namespace App\Http\Controllers;

use App\Models\JadwalPemeliharaan;
use App\Models\Mesin;
use App\Models\User;
use Illuminate\Http\Request;

class JadwalPemeliharaanController extends Controller
{
    // Tampilkan semua jadwal pemeliharaan
    public function index()
    {
        $jadwal = JadwalPemeliharaan::with(['mesin', 'user'])
        ->whereNot('status', 'Selesai')
        ->get();

        return view('admin.pemeliharaan.index', compact('jadwal'));
    }

    // Tampilkan form tambah jadwal pemeliharaan
    public function create()
    {
        $mesins = Mesin::all();
        $users = User::all();
        return view('admin.pemeliharaan.create', compact('mesins', 'users'));
    }

    // Simpan jadwal pemeliharaan baru
    public function store(Request $request)
    {
        $request->validate([
            'mesin_id' => 'required|exists:mesins,id',
            'user_id' => 'required|exists:users,id',
            'jenis' => 'required|in:rutin,incidental',
            'tanggal' => 'required|date',
            'deskripsi' => 'nullable|string',
            'status' => 'in:Terjadwal,Selesai,Dibatalkan'
        ]);

        JadwalPemeliharaan::create($request->all());

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal pemeliharaan berhasil ditambahkan!');
    }

    // Tampilkan form edit jadwal pemeliharaan
    public function edit($id)
    {
        $jadwal = JadwalPemeliharaan::findOrFail($id);
        $mesins = Mesin::all();
        $users = User::all();
        return view('admin.pemeliharaan.edit', compact('jadwal', 'mesins', 'users'));
    }

    // Update jadwal pemeliharaan
    public function update(Request $request, $id)
    {
        $jadwal = JadwalPemeliharaan::findOrFail($id);

        $request->validate([
            'mesin_id' => 'required|exists:mesins,id',
            'user_id' => 'required|exists:users,id',
            'jenis' => 'required|in:rutin,incidental',
            'tanggal' => 'required|date',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:Terjadwal,Selesai,Dibatalkan'
        ]);

        $jadwal->update($request->all());

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal pemeliharaan berhasil diperbarui!');
    }

    // Hapus jadwal pemeliharaan
    public function destroy($id)
    {
        $jadwal = JadwalPemeliharaan::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal pemeliharaan berhasil dihapus!');
    }
}
