<?php

namespace App\Http\Controllers;

use App\Models\Pertanyaan;
use App\Models\JadwalPemeliharaan;
use App\Models\SparePart;
use Illuminate\Http\Request;

class ScreeningController extends Controller
{
    // Tampilkan form screening
    public function create($jadwalId)
    {
        $jadwal = JadwalPemeliharaan::findOrFail($jadwalId);
        $spareParts = SparePart::all();

        return view('admin.pertanyaan.create', compact('jadwal', 'spareParts'));
    }

    // Simpan hasil screening
    public function store(Request $request)
    {
        $request->validate([
            'jadwal_pemeliharaan_id' => 'required|exists:jadwal_pemeliharaan,id',
            'getaran' => 'required|in:Ya,Tidak',
            'suara' => 'required|in:Ya,Tidak',
            'pelumasan' => 'required|in:Ya,Tidak',
            'bocor' => 'required|in:Ya,Tidak',
            'kerusakan' => 'required|in:Ya,Tidak',
            'tindakan' => 'required|in:Lanjut Operasi,Perbaikan,Pergantian Komponen',
            'komponen' => 'nullable|exists:spare_parts,id',
        ]);

        // Ambil info komponen jika tindakan adalah Pergantian Komponen
        $komponen = null;
        if ($request->tindakan === 'Pergantian Komponen' && $request->komponen) {
            $sparePart = SparePart::find($request->komponen);
            $komponen = $sparePart ? $sparePart->nama . ' (' . $sparePart->kode_part . ')' : null;
        }

        Pertanyaan::create([
            'jadwal_pemeliharaan_id' => $request->jadwal_pemeliharaan_id,
            'getaran' => $request->getaran,
            'suara' => $request->suara,
            'pelumasan' => $request->pelumasan,
            'bocor' => $request->bocor,
            'kerusakan' => $request->kerusakan,
            'tindakan' => $request->tindakan,
            'komponen' => $komponen,
        ]);

        // 🚀 Redirect ke halaman jadwal teknisi setelah simpan
        return redirect('/jadwal-pemeliharaan/jadwal-teknisi')
            ->with('success', 'Form screening berhasil disimpan dan data teknisi sudah diperbarui!');
    }

    // Tampilkan semua screening
    public function index()
    {
        $screenings = Pertanyaan::with('jadwal')->latest()->get();

        return view('admin.pertanyaan.index', compact('screenings'));
    }

    // Tampilkan screening berdasarkan jadwal
    public function show($jadwal_id)
    {
        $screening = Pertanyaan::where('jadwal_pemeliharaan_id', $jadwal_id)->firstOrFail();

        return view('admin.pertanyaan.show', compact('screening'));
    }

    // Tampilkan jawaban screening berdasarkan jadwal
    public function jawaban($id)
    {
        $pertanyaan = Pertanyaan::where('jadwal_pemeliharaan_id', $id)->get();

        return view('admin.pertanyaan.jawaban', compact('pertanyaan'));
    }
}
