<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Screening;
use App\Models\Mesin;
use App\Models\User;

class ScreeningController extends Controller
{
    /**
     * Menampilkan daftar screening.
     */
    public function index()
    {
        $screenings = Screening::with(['mesin', 'teknisi', 'admin'])->get();
        return view('admin.screenings.index', compact('screenings'));
    }
    public function indexteknisi()
    {
        $screenings = Screening::with(['mesin', 'teknisi', 'admin'])
        ->where('teknisi_id', auth()->id())
        ->get();
        return view('admin.screenings.indexteknisi', compact('screenings'));
    }

    /**
     * Menampilkan form tambah screening.
     */
    public function create()
    {
        $mesins = Mesin::all();
        $teknisis = User::where('level', 'Teknisi')->get();
        $admins = User::where('level', 'Administrator')->get();

        return view('admin.screenings.create', compact('mesins', 'teknisis', 'admins'));
    }

    /**
     * Menyimpan data screening baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'mesin_id' => 'required|exists:mesins,id',
            'teknisi_id' => 'required|exists:users,id',
            'admin_id' => 'required|exists:users,id',
            'tanggal_pemeriksaan' => 'required|date',
            'status_operasional' => 'required|in:Normal,Tidak Normal',
            'kode_error' => 'nullable|string',
            'suara_anomali' => 'boolean',
            'getaran_berlebih' => 'boolean',
            'kebocoran' => 'boolean',
            'terakhir_perawatan' => 'nullable|date',
            'tindakan_rekomendasi' => 'required|in:Lanjut Operasi,Perbaikan,Penggantian Komponen',
            'catatan' => 'nullable|string',
            'jawaban' => 'null|string',
        ]);

        Screening::create($request->all());

        return redirect()->route('screenings.index')->with('success', 'Screening berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail screening.
     */
    public function show(Screening $screening)
    {
        return view('admin.screenings.show', compact('screening'));
    }

    /**
     * Menampilkan form edit screening.
     */
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

    /**
     * Menyimpan perubahan pada screening.
     */
    public function update(Request $request, Screening $screening)
    {
        $request->validate([
            'mesin_id' => 'required|exists:mesins,id',
            'teknisi_id' => 'required|exists:users,id',
            'admin_id' => 'required|exists:users,id',
            'tanggal_pemeriksaan' => 'required|date',
            'status_operasional' => 'required|in:Normal,Tidak Normal',
            'kode_error' => 'nullable|string',
            'suara_anomali' => 'boolean',
            'getaran_berlebih' => 'boolean',
            'kebocoran' => 'boolean',
            'terakhir_perawatan' => 'nullable|date',
            'tindakan_rekomendasi' => 'required|in:Lanjut Operasi,Perbaikan,Penggantian Komponen',
            'catatan' => 'nullable|string',
            'jawaban' => 'nullable|string'
        ]);

        $screening->update($request->all());

        return redirect()->route('screenings.index')->with('success', 'Screening berhasil diperbarui.');
    }
    public function updateteknisi(Request $request, Screening $screening)
    {
        $request->validate([
            'mesin_id' => 'required|exists:mesins,id',
            'teknisi_id' => 'required|exists:users,id',
            'admin_id' => 'required|exists:users,id',
            'tanggal_pemeriksaan' => 'required|date',
            'status_operasional' => 'required|in:Normal,Tidak Normal',
            'kode_error' => 'nullable|string',
            'suara_anomali' => 'boolean',
            'getaran_berlebih' => 'boolean',
            'kebocoran' => 'boolean',
            'terakhir_perawatan' => 'nullable|date',
            'tindakan_rekomendasi' => 'required|in:Lanjut Operasi,Perbaikan,Penggantian Komponen',
            'catatan' => 'nullable|string',
            'jawaban' => 'nullable|string'
        ]);

        $screening->update($request->all());

        return redirect()->route('screenings.indexteknisi')->with('success', 'Screening berhasil diperbarui.');
    }

    /**
     * Menghapus screening.
     */
    public function destroy(Screening $screening)
    {
        $screening->delete();
        return redirect()->route('screenings.index')->with('success', 'Screening berhasil dihapus.');
    }
}
