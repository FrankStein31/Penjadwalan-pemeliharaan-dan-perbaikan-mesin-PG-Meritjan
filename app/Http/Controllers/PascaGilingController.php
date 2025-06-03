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
        // Validasi input
        $request->validate([
            'station_id' => 'required|exists:stations,id',
            'mesin_id' => 'required|exists:mesins,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:Terjadwal,Selesai,Dibatalkan',
        ]);

        // Simpan data pasca giling
        $pascaGiling = PascaGiling::create($request->all());

        // Kirim notifikasi ke teknisi di station terkait
        $station = \App\Models\Station::find($request->station_id);
        $teknisiList = $station->users; // Ambil teknisi di station ini

        foreach ($teknisiList as $teknisi) {
            if ($teknisi && $teknisi->telp) {
                $token = "RWQHVXjZJS2nuH698t7C";
                $target = $teknisi->telp;
                $tanggalFormatted = \Carbon\Carbon::parse($request->tanggal_mulai)->format('d-m-Y H:i');

                // Hitung hari sisa
                $hariSisa = \Carbon\Carbon::now()->diffInDays($request->tanggal_mulai, false);
                $pengingat = $hariSisa > 0
                    ? "$hariSisa hari lagi anda ada jadwal pasca giling di mesin {$pascaGiling->mesin->nama}. Jangan lupa ya!"
                    : "Segera lakukan jadwal pasca giling di mesin {$pascaGiling->mesin->nama}!";

                $pesan = "🛠️ *Jadwal Pasca Giling Baru!*\n\n"
                    . "👤 Nama: {$teknisi->nama}\n"
                    . "📅 Tanggal: $tanggalFormatted\n"
                    . "📍 Station: {$station->nama_station}\n"
                    . "🔧 Mesin: {$pascaGiling->mesin->nama}\n"
                    . "📝 Deskripsi: " . ($request->deskripsi ?? '-') . "\n\n"
                    . "📣 *Pengingat:* $pengingat";

                // Kirim pesan via Fonnte
                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_URL => 'https://api.fonnte.com/send',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => [
                        'target' => $target,
                        'message' => $pesan,
                    ],
                    CURLOPT_HTTPHEADER => [
                        "Authorization: $token"
                    ],
                ]);
                curl_exec($curl);
                curl_close($curl);
            }
        }

        return redirect()->route('pasca-giling.index')
            ->with('success', 'Jadwal pasca giling berhasil ditambahkan dan pengingat telah dikirim ke teknisi!');
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
