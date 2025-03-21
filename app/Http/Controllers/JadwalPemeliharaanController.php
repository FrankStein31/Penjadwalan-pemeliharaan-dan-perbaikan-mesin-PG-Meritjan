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
    public function indexteknisi()
{
    $jadwal = JadwalPemeliharaan::with(['mesin', 'user'])
        ->where('user_id', auth()->id()) // Filter hanya untuk user yang sedang login
        ->whereNot('status', 'Selesai')
        ->get();

    return view('admin.pemeliharaan.index', compact('jadwal'));
}
public function markAsSelesai($id)
{
    $jadwal = JadwalPemeliharaan::findOrFail($id);
    $jadwal->update([
        'status' => 'Selesai',
        'updated_at' => now()
    ]);

    return redirect()->back()->with('success', 'Jadwal berhasil diselesaikan.');
}
public function markAsDibatakan($id)
{
    $jadwal = JadwalPemeliharaan::findOrFail($id);
    $jadwal->update([
        'status' => 'Dibatalkan',
        'updated_at' => now() // Memperbarui timestamp ke waktu saat ini
    ]);
    return redirect()->back()->with('success', 'Jadwal berhasil dibatalkan.');
}


    // Tampilkan form tambah jadwal pemeliharaan
    public function create()
    {
        $mesins = Mesin::with('station')->get(); // Pastikan mesin memiliki station
    $users = User::where('level', 'teknisi')->get(); // Hanya teknisi
    return view('admin.pemeliharaan.create', compact('mesins', 'users'));
        $mesins = Mesin::all();
        return view('admin.pemeliharaan.create', compact('mesins'));
    }

    // public function getTeknisiByMesin($mesin_id)
    // {
    //     $teknisi = User::whereHas('mesin', function ($query) use ($mesin_id) {
    //         $query->where('mesin_id', $mesin_id);
    //     })->get();

    //     return response()->json($teknisi);
    // }
    public function getTeknisiByMesin(Request $request)
    {
        $mesin = Mesin::with('station')->find($request->mesin_id);

        if (!$mesin || !$mesin->station) {
            return response()->json(['message' => 'Mesin atau station tidak ditemukan'], 404);
        }

        $teknisis = User::where('station_id', $mesin->station->id)->get();

        return response()->json($teknisis);
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
