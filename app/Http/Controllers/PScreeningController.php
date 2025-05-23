<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Screening;
use App\Models\Mesin;
use App\Models\User;
use App\Models\JadwalPemeliharaan;

class PScreeningController extends Controller
{
    public function index()
    {
        $screenings = Screening::with(['mesin', 'teknisi', 'admin'])->get();
        $jadwalId = 1;
        return view('admin.screenings.index', compact('screenings', 'jadwalId'));
    }

    public function indexteknisi()
    {
        $screenings = Screening::with(['mesin', 'teknisi', 'admin'])
            ->where('teknisi_id', auth()->id())
            ->get();
        return view('admin.screenings.indexteknisi', compact('screenings'));
    }

    /**
     * Show form create screening for a given jadwal ID
     */
    public function create($jadwalId)
    {
        $jadwal = JadwalPemeliharaan::findOrFail($jadwalId);
        $mesins = Mesin::all();
        $teknisis = User::where('level', 'Teknisi')->get();
        $admins = User::where('level', 'Administrator')->get();

        return view('admin.screenings.create', compact('jadwal', 'mesins', 'teknisis', 'admins'));
    }

    /**
     * Store new screening data
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'mesin_id' => 'required|exists:mesins,id',
            'teknisi_id' => 'required|exists:users,id',
            'admin_id' => 'required|exists:users,id',
            'jadwal_id' => 'required|exists:jadwal_pemeliharaan,id',
            'tanggal_pemeriksaan' => 'required|date',
            'status_operasional' => 'required|in:Normal,Tidak Normal',
            'kode_error' => 'nullable|string',
            'suara_anomali' => 'sometimes|boolean',
            'getaran_berlebih' => 'sometimes|boolean',
            'kebocoran' => 'sometimes|boolean',
            'terakhir_perawatan' => 'nullable|date',
            'tindakan_rekomendasi' => 'required|in:Lanjut Operasi,Perbaikan,Penggantian Komponen',
            'catatan' => 'nullable|string',
            'jawaban' => 'nullable|string',
        ]);

        Screening::create($validated);

        return redirect()->route('screenings.index')->with('success', 'Screening berhasil ditambahkan.');
    }

    public function show(Screening $screening)
    {
        return view('admin.screenings.show', compact('screening'));
    }

    public function edit(Screening $screening)
    {
        $mesins = Mesin::all();
        $teknisis = User::where('level', 'Teknisi')->get();
        $admins = User::where('level', 'Administrator')->get();

        return view('admin.screenings.edit', compact('screening', 'mesins', 'teknisis', 'admins'));
    }

    public function editteknisi(Screening $screening)
    {
        $mesins = Mesin::all();
        $teknisis = User::where('level', 'Teknisi')->get();
        $admins = User::where('level', 'Administrator')->get();

        return view('admin.screenings.editteknisi', compact('screening', 'mesins', 'teknisis', 'admins'));
    }

    public function update(Request $request, Screening $screening)
    {
        $validated = $request->validate([
            'mesin_id' => 'required|exists:mesins,id',
            'teknisi_id' => 'required|exists:users,id',
            'admin_id' => 'required|exists:users,id',
            'tanggal_pemeriksaan' => 'required|date',
            'status_operasional' => 'required|in:Normal,Tidak Normal',
            'kode_error' => 'nullable|string',
            'suara_anomali' => 'sometimes|boolean',
            'getaran_berlebih' => 'sometimes|boolean',
            'kebocoran' => 'sometimes|boolean',
            'terakhir_perawatan' => 'nullable|date',
            'tindakan_rekomendasi' => 'required|in:Lanjut Operasi,Perbaikan,Penggantian Komponen',
            'catatan' => 'nullable|string',
            'jawaban' => 'nullable|string',
        ]);

        $screening->update($validated);

        return redirect()->route('screenings.index')->with('success', 'Screening berhasil diperbarui.');
    }

    public function updateteknisi(Request $request, Screening $screening)
    {
        $validated = $request->validate([
            'mesin_id' => 'required|exists:mesins,id',
            'teknisi_id' => 'required|exists:users,id',
            'admin_id' => 'required|exists:users,id',
            'tanggal_pemeriksaan' => 'required|date',
            'status_operasional' => 'required|in:Normal,Tidak Normal',
            'kode_error' => 'nullable|string',
            'suara_anomali' => 'sometimes|boolean',
            'getaran_berlebih' => 'sometimes|boolean',
            'kebocoran' => 'sometimes|boolean',
            'terakhir_perawatan' => 'nullable|date',
            'tindakan_rekomendasi' => 'required|in:Lanjut Operasi,Perbaikan,Penggantian Komponen',
            'catatan' => 'nullable|string',
            'jawaban' => 'nullable|string',
        ]);

        $screening->update($validated);

        return redirect()->route('screenings.indexteknisi')->with('success', 'Screening berhasil diperbarui.');
    }

    public function destroy(Screening $screening)
    {
        $screening->delete();
        return redirect()->route('screenings.index')->with('success', 'Screening berhasil dihapus.');
    }
}
