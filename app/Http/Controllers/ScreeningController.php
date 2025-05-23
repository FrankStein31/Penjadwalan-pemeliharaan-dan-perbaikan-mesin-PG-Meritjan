<?php

namespace App\Http\Controllers;

use App\Models\Pertanyaan;
use App\Models\JadwalPemeliharaan;
use Illuminate\Http\Request;
use App\Models\Screening;

class ScreeningController extends Controller
{
    // Simpan hasil screening
    //buat kan public function create untuk menampilkan form screening
    public function create($jadwalId)
    {
        $jadwal = JadwalPemeliharaan::findOrFail($jadwalId);
        return view('admin.pertanyaan.create', compact('jadwal'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'jadwal_pemeliharaan_id' => 'required|exists:jadwal_pemeliharaan,id', // pastikan relasi valid
            'getaran' => 'required|in:Ya,Tidak',
            'suara' => 'required|in:Ya,Tidak',
            'pelumasan' => 'required|in:Ya,Tidak',
            'bocor' => 'required|in:Ya,Tidak',
            'kerusakan' => 'required|in:Ya,Tidak',
            'tindakan' => 'required|in:Lanjut Operasi,Perbaikan,Pergantian Komponen',
        ]);

        Pertanyaan::create($request->all());

        return redirect()->back()->with('success', 'Form screening berhasil disimpan!');
    }

    // (Opsional) Menampilkan hasil screening tertentu
    public function show($jadwal_id)
    {
        $screening = Pertanyaan::where('jadwal_id', $jadwal_id)->firstOrFail();

        return view('pertanyaan.show', compact('screening'));
    }

    public function jawaban($id)
    {
        $pertanyaan = JadwalPemeliharaan::join("pertanyaan", "jadwal_pemeliharaan.id", "=", "pertanyaan.jadwal_pemeliharaan_id")->where("jadwal_pemeliharaan.id", "=", $id)->get(); // atau sesuaikan field relasinya
        return view('admin.pertanyaan.jawaban', compact('pertanyaan'));
    }
}
