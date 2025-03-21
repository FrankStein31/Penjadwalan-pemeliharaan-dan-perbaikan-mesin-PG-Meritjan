<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalPemeliharaan;
use Dompdf\Dompdf;
use Dompdf\Options;
 // Perbaikan alias Pdf

class RiwayatLaporanController extends Controller
{
    public function index()
    {
        $jadwal = JadwalPemeliharaan::with(['mesin', 'user'])
            ->where('status', 'Selesai')
            ->get();

        return view('admin.riwayat.index', compact('jadwal'));
    }
    public function indexteknisi()
    {
        $jadwal = JadwalPemeliharaan::with(['mesin', 'user'])
        ->where('user_id', auth()->id())
        ->where('status', 'Selesai')
        ->get();


        return view('admin.riwayat.index', compact('jadwal'));
    }

    public function exportPDF()
    {
        $jadwal = JadwalPemeliharaan::with(['mesin', 'user'])
            ->where('status', 'Selesai')
            ->get();

        // Ambil tampilan HTML dari Blade
        $html = view('admin.riwayat.pdf', compact('jadwal'))->render();

        // Konfigurasi Dompdf
        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true); // Jika ada gambar dari URL

        // Buat instance Dompdf
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        // Unduh file PDF
        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="riwayat_pemeliharaan.pdf"');
    }
}
