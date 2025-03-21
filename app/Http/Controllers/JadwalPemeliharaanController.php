<?php

namespace App\Http\Controllers;

use App\Models\JadwalPemeliharaan;
use App\Models\Mesin;
use App\Models\User;
use App\Models\Station;
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
        $mesins = Mesin::all();
        $teknisis = User::where('level', 'Teknisi')->get();
        $stations = Station::all();
        return view('admin.pemeliharaan.create', compact('mesins', 'teknisis', 'stations'));
    }

    public function getTeknisiByMesin($mesin_id)
    {
        $teknisi = User::whereHas('mesin', function ($query) use ($mesin_id) {
            $query->where('mesin_id', $mesin_id);
        })->get();

        return response()->json($teknisi);
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
        $teknisis = User::where('level', 'Teknisi')->get();
        $stations = Station::all();
        return view('admin.pemeliharaan.edit', compact('jadwal', 'mesins', 'teknisis', 'stations'));
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

    // Tambahkan method baru
    public function getMesinByStation($station_id)
    {
        $mesins = Mesin::where('station_id', $station_id)->get();
        return response()->json($mesins);
    }

    public function getTeknisiByStation($station_id)
    {
        $teknisis = User::where('level', 'Teknisi')
                        ->where('station_id', $station_id)
                        ->get();
        return response()->json($teknisis);
    }
}
