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
        $spareParts = SparePart::orderBy('nama')->get(); // urut biar rapi

        return view('admin.pertanyaan.create', compact('jadwal', 'spareParts'));
    }

    // Simpan hasil screening
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jadwal_pemeliharaan_id' => 'required|exists:jadwal_pemeliharaan,id',
            'getaran' => 'required|in:Ya,Tidak',
            'suara' => 'required|in:Ya,Tidak',
            'pelumasan' => 'required|in:Ya,Tidak',
            'bocor' => 'required|in:Ya,Tidak',
            'kerusakan' => 'required|in:Ya,Tidak',
            'tindakan' => 'required|in:Lanjut Operasi,Perbaikan,Pergantian Komponen',
            'komponen' => 'nullable|exists:spare_parts,id',
        ]);

        $komponen = null;

        if ($request->tindakan === 'Pergantian Komponen') {
            $sparePart = SparePart::find($request->komponen);

            if (!$sparePart) {
                return back()->withErrors(['komponen' => 'Komponen tidak ditemukan.'])->withInput();
            }

            if ($sparePart->stok <= 0) {
                return back()->withErrors(['komponen' => 'Stok komponen habis.'])->withInput();
            }

            // Simpan nama komponen + kode part ke field `komponen`
            $komponen = $sparePart->nama . ' (' . $sparePart->kode_part . ')';

            // Kurangi stok
            $sparePart->stok -= 1;
            $sparePart->save();
        }

        Pertanyaan::create([
            'jadwal_pemeliharaan_id' => $validated['jadwal_pemeliharaan_id'],
            'getaran' => $validated['getaran'],
            'suara' => $validated['suara'],
            'pelumasan' => $validated['pelumasan'],
            'bocor' => $validated['bocor'],
            'kerusakan' => $validated['kerusakan'],
            'tindakan' => $validated['tindakan'],
            'komponen' => $komponen,
        ]);

        return redirect('/jadwal-pemeliharaan/jadwal-teknisi')
            ->with('success', 'Form screening berhasil disimpan dan stok suku cadang sudah diperbarui!');
    }

    // Index semua screening
    public function index()
    {
        $screenings = Pertanyaan::with('jadwal')->latest()->get();
        return view('admin.pertanyaan.index', compact('screenings'));
    }

    // Detail screening 1 data (bisa dipakai kalau mau)
    public function show($jadwal_id)
    {
        $screening = Pertanyaan::where('jadwal_pemeliharaan_id', $jadwal_id)->firstOrFail();
        return view('admin.pertanyaan.show', compact('screening'));
    }

    // Tampilkan jawaban screening berdasarkan jadwal
    public function jawaban($id)
    {
        $pertanyaan = Pertanyaan::where('jadwal_pemeliharaan_id', $id)->get();

        // Tambahkan pengecekan stok komponen di sini
        foreach ($pertanyaan as $item) {
            if ($item->tindakan === 'Pergantian Komponen' && $item->komponen) {
                // Ambil nama & kode part dari string "Nama (Kode)"
                if (preg_match('/^(.*?)\s*\((.*?)\)$/', $item->komponen, $match)) {
                    $nama = trim($match[1]);  // contoh: "Roll gilingan"
                    $kode = trim($match[2]);  // contoh: "001"

                    $sparePart = SparePart::where('nama', $nama)
                        ->where('kode_part', $kode)
                        ->first();

                    $item->stok_komponen = $sparePart ? $sparePart->stok : 'Tidak ditemukan unit';
                } else {
                    $item->stok_komponen = 'Format komponen tidak valid';
                }
            }
        }

        return view('admin.pertanyaan.jawaban', compact('pertanyaan'));
    }
}
