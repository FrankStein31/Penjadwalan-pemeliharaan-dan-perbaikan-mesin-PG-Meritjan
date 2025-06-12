<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mesin;
use App\Models\JadwalPemeliharaan;
use App\Models\TeknisiMesin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login');
        }

        if ($user->level === 'Administrator' || $user->level === 'Manajer Teknisi') {
            // Statistik umum
            $jumlahUser = User::where('level', 'Teknisi')->count();
            $jumlahMesin = Mesin::count();
            $totalPemeliharaanTerjadwal = JadwalPemeliharaan::where('status', 'Terjadwal')->count();

            // Ambil filter tanggal dari request
            $tanggalAwal = $request->input('tanggal_awal');
            $tanggalAkhir = $request->input('tanggal_akhir');

            // Format tanggal jika ada
            if ($tanggalAwal && $tanggalAkhir) {
                $tanggalAwal = Carbon::parse($tanggalAwal)->startOfDay();
                $tanggalAkhir = Carbon::parse($tanggalAkhir)->endOfDay();
            }

            // Ambil jadwal terbaru (dengan filter)
            $jadwalQuery = JadwalPemeliharaan::with(['mesin', 'user']);

            if ($tanggalAwal && $tanggalAkhir) {
                $jadwalQuery->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);
            }

            $jadwalTerbaru = $jadwalQuery->orderByDesc('created_at')->take(5)->get();

            // Statistik jenis pemeliharaan (tetap total semua data)
            $jumlahRutin = JadwalPemeliharaan::where('jenis', 'rutin')->count();
            $jumlahIncidental = JadwalPemeliharaan::where('jenis', 'incidental')->count();

            // Statistik ketepatan teknisi (dengan filter tanggal selesai)
            $teknisiList = User::where('level', 'Teknisi')->get();
            $labelsTeknisi = [];
            $dataKetepatan = [];

            foreach ($teknisiList as $teknisi) {
                $pemeliharaanSelesaiQuery = JadwalPemeliharaan::where('user_id', $teknisi->id)
                    ->where('status', 'Selesai');

                if ($tanggalAwal && $tanggalAkhir) {
                    $pemeliharaanSelesaiQuery->whereBetween('updated_at', [$tanggalAwal, $tanggalAkhir]);
                }

                $pemeliharaanSelesai = $pemeliharaanSelesaiQuery->get();

                $total = $pemeliharaanSelesai->count();
                $tepatWaktu = 0;

                foreach ($pemeliharaanSelesai as $jadwal) {
                    $targetDate = Carbon::parse($jadwal->tanggal);
                    $selesaiDate = Carbon::parse($jadwal->updated_at);

                    if ($selesaiDate->lessThanOrEqualTo($targetDate)) {
                        $tepatWaktu++;
                    }
                }

                $persentase = $total > 0 ? round(($tepatWaktu / $total) * 100, 2) : 0;

                $labelsTeknisi[] = $teknisi->nama;
                $dataKetepatan[] = $persentase;
            }

            return view('dashboard', compact(
                'jumlahUser',
                'jumlahMesin',
                'totalPemeliharaanTerjadwal',
                'jadwalTerbaru',
                'jumlahRutin',
                'jumlahIncidental',
                'labelsTeknisi',
                'dataKetepatan',
                'tanggalAwal',
                'tanggalAkhir'
            ));
        }

        // Jika user adalah Teknisi
        if ($user->level === 'Teknisi') {
            $userId = $user->id;

            $mesinTeknisi = TeknisiMesin::where('user_id', $userId)->count();
            $jadwalTeknisi = JadwalPemeliharaan::where('user_id', $userId)->count();
            $jadwalTerjadwal = JadwalPemeliharaan::where('user_id', $userId)
                ->where('status', 'Terjadwal')
                ->count();

            $jadwalTerbaru = JadwalPemeliharaan::with('mesin')
                ->where('user_id', $userId)
                ->orderByDesc('created_at')
                ->take(5)
                ->get();

            return view('teknisi.dashboard', compact(
                'mesinTeknisi',
                'jadwalTeknisi',
                'jadwalTerjadwal',
                'jadwalTerbaru'
            ));
        }

        return redirect('/unauthorized');
    }
}