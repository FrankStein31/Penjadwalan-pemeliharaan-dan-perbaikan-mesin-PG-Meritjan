<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalPemeliharaan;
use App\Models\Mesin;
use Illuminate\Support\Facades\Auth;
use Dompdf\Dompdf;
use Dompdf\Options;

class RiwayatLaporanController extends Controller
{
    /**
     * Menampilkan riwayat pemeliharaan untuk admin dan manajer.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = JadwalPemeliharaan::with(['mesin', 'user'])
            ->where('status', 'Selesai');

        // Filter berdasarkan mesin (jika ada)
        if ($request->filled('mesin_id')) {
            $query->where('mesin_id', $request->mesin_id);
        }

        $jadwal = $query->get();
        $mesinList = Mesin::all(); // Untuk dropdown filter mesin

        return view('admin.riwayat.index', compact('jadwal', 'mesinList'));
    }

    /**
     * Menampilkan riwayat teknisi sendiri.
     */
    public function indexteknisi(Request $request)
    {
        $query = JadwalPemeliharaan::with(['mesin', 'user'])
            ->where('user_id', auth()->id())
            ->where('status', 'Selesai');

        // Filter mesin jika ada (opsional untuk teknisi juga)
        if ($request->filled('mesin_id')) {
            $query->where('mesin_id', $request->mesin_id);
        }

        $jadwal = $query->get();

        return view('admin.riwayat.index', compact('jadwal'));
    }

    /**
     * Export PDF untuk admin/manajer.
     */
    public function exportPDF(Request $request)
    {
        $query = JadwalPemeliharaan::with(['mesin', 'user'])
            ->where('status', 'Selesai');

        // Tambahkan filter mesin jika ada
        if ($request->filled('mesin_id')) {
            $query->where('mesin_id', $request->mesin_id);
        }

        $jadwal = $query->get();

        // Render HTML ke PDF
        $html = view('admin.riwayat.pdf', compact('jadwal'))->render();

        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="riwayat_pemeliharaan.pdf"');
    }
}