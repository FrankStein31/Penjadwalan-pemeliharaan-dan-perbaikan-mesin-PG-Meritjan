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
    public function index()
    {
        $jadwal = JadwalPemeliharaan::with(['mesin', 'user', 'screening'])->get();
        $pertanyaan = Pertanyaan::all();
        return view('admin.pemeliharaan.index', compact('jadwal', 'pertanyaan'));
    }

    public function indexteknisi()
    {
        $jadwal = JadwalPemeliharaan::with(['mesin', 'user'])
            ->where('user_id', auth()->id())
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
            'updated_at' => now()
        ]);
        return redirect()->back()->with('success', 'Jadwal berhasil dibatalkan.');
    }

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

    public function store(Request $request)
    {
        $request->validate([
            'mesin_id' => 'required|exists:mesins,id',
            'user_id' => 'required|exists:users,id',
            'jenis' => 'required|in:rutin,incidental',
            'tanggal' => 'required|date',
            'deskripsi' => 'nullable|string',
            'status' => 'in:Terjadwal,Selesai,Dibatalkan',
            'pertanyaan' => 'required|string',
        ]);

        $jadwal = JadwalPemeliharaan::create($request->all());

        $teknisi = User::find($request->user_id);
        if ($teknisi) {
            $token = "RQCD2A7WMdZHJfEYDTDK";
            $target = $teknisi->telp;
            $tanggalFormatted = \Carbon\Carbon::parse($request->tanggal)->format('d-m-Y H:i');
            $hariSisa = \Carbon\Carbon::now()->diffInDays($request->tanggal, false);
            $pengingat = $hariSisa > 0 ? "$hariSisa hari lagi anda ada perbaikan mesin, tolong segera diselesaikan." : "Segera lakukan perbaikan mesin sesuai jadwal.";

            $data = "🔧 Jadwal Pemeliharaan Baru!!!\n\n"
                . "👤 Nama: {$teknisi->nama}\n"
                . "📅 Tanggal: $tanggalFormatted\n"
                . "📍 Mesin: " . $jadwal->mesin->nama . "\n"
                . "📝 Jenis: " . ucfirst($jadwal->jenis) . "\n"
                . "🧾 Deskripsi: " . ($request->deskripsi ?? '-') . "\n\n"
                . "📣 Pengingat: $pengingat";

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

    public function edit($id)
    {
        $jadwal = JadwalPemeliharaan::findOrFail($id);
        $mesins = Mesin::all();
        $teknisis = User::where('level', 'Teknisi')->get();
        $stations = Station::all();
        return view('admin.pemeliharaan.edit', compact('jadwal', 'mesins', 'teknisis', 'stations'));
    }

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

    public function destroy($id)
    {
        $jadwal = JadwalPemeliharaan::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal pemeliharaan berhasil dihapus!');
    }

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

    // ✅ Tambahan Baru: Form Upload Bukti
    public function formUploadBukti($id)
    {
        $jadwal = JadwalPemeliharaan::findOrFail($id);
        return view('admin.pemeliharaan.upload_bukti', compact('jadwal'));
    }

    // ✅ Tambahan Baru: Simpan Bukti Upload
    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'foto_sebelum' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'foto_sesudah' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'video' => 'nullable|mimetypes:video/mp4,video/webm,video/quicktime|max:10240'
        ]);

        $jadwal = JadwalPemeliharaan::findOrFail($id);

        if ($request->hasFile('foto_sebelum')) {
            $jadwal->foto_sebelum = $request->file('foto_sebelum')->store('bukti/sebelum', 'public');
        }

        if ($request->hasFile('foto_sesudah')) {
            $jadwal->foto_sesudah = $request->file('foto_sesudah')->store('bukti/sesudah', 'public');
        }

        if ($request->hasFile('video')) {
            $jadwal->video = $request->file('video')->store('bukti/video', 'public');
        }

        $jadwal->save();

        return redirect()->route('admin.jadwal.indexteknisi')->with('success', 'Bukti berhasil diunggah.');
    }
}
