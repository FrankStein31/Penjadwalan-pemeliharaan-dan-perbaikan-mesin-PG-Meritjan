<?php

namespace App\Http\Controllers;

use App\Models\JadwalPemeliharaan;
use App\Models\Mesin;
use App\Models\User;
use App\Models\Station;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;

class JadwalPemeliharaanController extends Controller
{
    // Tampilkan semua jadwal pemeliharaan
    public function index()
    {
        $jadwal = JadwalPemeliharaan::with(['mesin', 'user', 'screening'])
            ->whereNot('status', 'Selesai')
            ->get();

        $pertanyaan = Pertanyaan::all();

        return view('admin.pemeliharaan.index', compact('jadwal', 'pertanyaan'));
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
        // Validasi input
        $request->validate([
            'mesin_id' => 'required|exists:mesins,id',
            'user_id' => 'required|exists:users,id',
            'jenis' => 'required|in:rutin,incidental',
            'tanggal' => 'required|date',
            'deskripsi' => 'nullable|string',
            'status' => 'in:Terjadwal,Selesai,Dibatalkan',
            'pertanyaan' => 'required|string',
        ]);

        // Simpan ke database
        $jadwal = JadwalPemeliharaan::create($request->all());

        // Ambil data teknisi berdasarkan user_id yang dikirim
        $teknisi = User::find($request->user_id);

        if ($teknisi) {
            $token = "RWQHVXjZJS2nuH698t7C"; // Token API Fonnte
            $target = $teknisi->telp; // Pastikan nomor dalam format internasional
            $tanggalFormatted = \Carbon\Carbon::parse($request->tanggal)->format('d-m-Y H:i');

            // Hitung selisih hari dari sekarang ke tanggal perbaikan
            $hariSisa = \Carbon\Carbon::now()->diffInDays($request->tanggal, false);
            $pengingat = $hariSisa > 0 ? "$hariSisa hari lagi anda ada perbaikan mesin, tolong segera diselesaikan." : "Segera lakukan perbaikan mesin sesuai jadwal.";

            $data = "🔧 Jadwal Pemeliharaan Baru!!!\n\n"
                . "👤 Nama: {$teknisi->nama}\n"
                . "📅 Tanggal: $tanggalFormatted\n"
                . "📍 Mesin: " . $jadwal->mesin->nama . "\n"
                . "📝 Jenis: " . ucfirst($jadwal->jenis) . "\n"
                . "🧾 Deskripsi: " . ($request->deskripsi ?? '-') . "\n\n"
                . "📣 Pengingat: $pengingat";

            // Kirim melalui Fonnte
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => array(
                    'target' => $target,
                    'message' => $data,
                ),
                CURLOPT_HTTPHEADER => array(
                    "Authorization: $token"
                ),
            ));
            curl_exec($curl);
            curl_close($curl);
        }

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal pemeliharaan berhasil ditambahkan dan notifikasi dikirim!');
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