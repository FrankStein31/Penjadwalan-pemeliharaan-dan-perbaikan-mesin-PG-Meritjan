<?php

namespace App\Http\Controllers;

use App\Models\LaporanIncidental;
use App\Models\Mesin;
use App\Models\SparePart;
use App\Models\Station;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanIncidentalController extends Controller
{
    public function index()
    {
        $query = LaporanIncidental::with(['mesin', 'station', 'sparePart', 'user']);

        if (auth()->user()->level === 'Teknisi' || auth()->user()->level === 'Operator Mesin') {
            $query->where('user_id', auth()->id());
        }

        $laporans = $query->paginate(10);
        return view('laporan_incidental.index', compact('laporans'));
    }

    public function create()
    {
        $stations = Station::all(['id', 'nama_station']);
        $spareParts = SparePart::all(['id', 'nama', 'kode_part']);
        $mesins = Mesin::all(['id', 'nama']);
        return view('laporan_incidental.create', compact('stations', 'spareParts', 'mesins'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mesin_id' => 'required|integer|exists:mesins,id',
            'station_id' => 'required|integer|exists:stations,id',
            'description' => 'required|string',
            'photo_path' => 'nullable|image|max:2048',
            'requires_spare_part' => 'required|boolean',
            'spare_part_id' => 'nullable|integer|exists:spare_parts,id',
        ]);

        $path = $request->hasFile('photo_path')
            ? $request->file('photo_path')->store('laporan-insidental', 'public')
            : null;

        LaporanIncidental::create([
            'user_id' => auth()->id(),
            'mesin_id' => $request->mesin_id,
            'station_id' => $request->station_id,
            'description' => $request->description,
            'photo_path' => $path,
            'requires_spare_part' => $request->requires_spare_part,
            'spare_part_id' => $request->requires_spare_part ? $request->spare_part_id : null,
        ]);

        return redirect()->route('laporan-insidental.index')->with('success', 'Laporan insidental berhasil dikirim.');
    }

    public function show($id)
    {
        $laporan = LaporanIncidental::with(['mesin', 'station', 'sparePart', 'user'])->findOrFail($id);
        return view('laporan_incidental.show', compact('laporan'));
    }

    public function edit($id)
    {
        $laporan = LaporanIncidental::with(['mesin', 'station', 'sparePart'])->findOrFail($id);
        $stations = Station::all(['id', 'nama_station']);
        $mesins = Mesin::all(['id', 'nama']);
        $spareParts = SparePart::all(['id', 'nama', 'kode_part']);

        return view('laporan_incidental.edit', compact('laporan', 'stations', 'mesins', 'spareParts'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'mesin_id' => 'required|integer|exists:mesins,id',
            'station_id' => 'required|integer|exists:stations,id',
            'description' => 'required|string',
            'photo_path' => 'nullable|image|max:2048',
            'requires_spare_part' => 'required|boolean',
            'spare_part_id' => 'nullable|integer|exists:spare_parts,id',
        ]);

        $laporan = LaporanIncidental::findOrFail($id);

        if ($request->hasFile('photo_path')) {
            if ($laporan->photo_path) {
                Storage::disk('public')->delete($laporan->photo_path);
            }
            $laporan->photo_path = $request->file('photo_path')->store('laporan-insidental', 'public');
        }

        $laporan->mesin_id = $request->mesin_id;
        $laporan->station_id = $request->station_id;
        $laporan->description = $request->description;
        $laporan->requires_spare_part = $request->requires_spare_part;
        $laporan->spare_part_id = $request->requires_spare_part ? $request->spare_part_id : null;

        $laporan->save();

        return redirect()->route('laporan-insidental.index')->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $laporan = LaporanIncidental::findOrFail($id);

        if ($laporan->photo_path) {
            Storage::disk('public')->delete($laporan->photo_path);
        }

        $laporan->delete();

        return redirect()->route('laporan-insidental.index')->with('success', 'Laporan berhasil dihapus.');
    }

    public function approve($id)
    {
        $laporan = LaporanIncidental::findOrFail($id);
        $laporan->status = 'Setuju';
        $laporan->save();

        return redirect()->back()->with('success', 'Laporan telah disetujui.');
    }

    public function reject($id)
    {
        $laporan = LaporanIncidental::findOrFail($id);
        $laporan->status = 'Tolak';
        $laporan->save();

        return redirect()->back()->with('success', 'Laporan telah ditolak.');
    }

    public function selesai($id)
    {
        $laporan = LaporanIncidental::findOrFail($id);
        $laporan->status = 'Selesai';
        $laporan->save();

        return redirect()->back()->with('success', 'Laporan telah diselesaikan.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:Setuju,Tolak,Selesai,Dalam Peninjauan',
        ]);

        $laporan = LaporanIncidental::with(['mesin', 'station'])->findOrFail($id);
        $laporan->status = $request->status;
        $laporan->save();

        return redirect()->back()->with('success', 'Status laporan berhasil diubah!');
    }

    public function assignForm($id)
    {
        $laporan = LaporanIncidental::with(['mesin', 'station'])->findOrFail($id);
        $teknisis = User::where('level', 'Teknisi')
            ->where('station_id', $laporan->station_id)
            ->get();

        return view('laporan_incidental.assign', compact('laporan', 'teknisis'));
    }

    public function assignTeknisi(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $laporan = LaporanIncidental::findOrFail($id);

        $teknisi = User::find($request->user_id);
        if ($teknisi) {
            $token = "RWQHVXjZJS2nuH698t7C";
            $target = $teknisi->telp;

            $data = "🔧 Laporan Insidental Telah Disetujui!\n\n"
                . "👤 Nama Teknisi: {$teknisi->nama}\n"
                . "📍 Mesin: {$laporan->mesin->nama}\n"
                . "🏭 Station: {$laporan->station->nama_station}\n"
                . "📍 Deskripsi: {$laporan->description}\n\n"
                . "Silakan segera lakukan pengecekan dan perbaikan.";

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

        return redirect()->route('laporan-insidental.index')->with('success', 'Teknisi berhasil ditugaskan dan notifikasi telah dikirim.');
    }

    public function cetak($id)
    {
        $laporan = LaporanIncidental::with(['mesin', 'station'])->findOrFail($id);

        if (auth()->user()->level !== 'Manajer Teknisi' || $laporan->status !== 'Selesai') {
            abort(403, 'Anda tidak memiliki izin untuk mencetak laporan ini.');
        }

        $html = view('laporan_incidental.pdf', compact('laporan'))->render();

        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="Laporan_Insidental_' . $laporan->id . '.pdf"');
    }

    public function exportPDF($id)
    {
        $laporan = LaporanIncidental::with(['mesin', 'station', 'sparePart'])->findOrFail($id);

        $html = view('laporan_incidental.pdf', compact('laporan'))->render();

        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="Laporan_Insidental_' . $laporan->id . '.pdf"');
    }
}
