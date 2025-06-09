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
    public function index()
    {
        if (Auth::user()->level === 'Administrator' || Auth::user()->level === 'Manajer Teknisi') {
            $jumlahUser = User::count();
            $jumlahMesin = Mesin::count();
            $totalPemeliharaanTerjadwal = JadwalPemeliharaan::where('status', 'Terjadwal')->count();
            $jadwalTerbaru = JadwalPemeliharaan::with(['mesin', 'user'])
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            // Jumlah berdasarkan jenis pemeliharaan
            $jumlahRutin = JadwalPemeliharaan::where('jenis', 'rutin')->count();
            $jumlahIncidental = JadwalPemeliharaan::where('jenis', 'incidental')->count();

            // --- Hitung ketepatan teknisi ---
            $teknisi = User::where('level', 'Teknisi')->get();

            $labelsTeknisi = [];
            $dataKetepatan = [];

            foreach ($teknisi as $user) {
                $pemeliharaanSelesai = JadwalPemeliharaan::where('user_id', $user->id)
                    ->where('status', 'Selesai')
                    ->get();

                $totalTugas = $pemeliharaanSelesai->count();

                if ($totalTugas == 0) {
                    $persen = 0;
                } else {
                    $tepatWaktuCount = 0;
                    foreach ($pemeliharaanSelesai as $p) {
                        $tanggalTarget = Carbon::parse($p->tanggal);
                        $tanggalSelesai = Carbon::parse($p->updated_at);

                        if ($tanggalSelesai->lessThanOrEqualTo($tanggalTarget)) {
                            $tepatWaktuCount++;
                        }
                    }
                    $persen = round(($tepatWaktuCount / $totalTugas) * 100, 2);
                }

                $labelsTeknisi[] = $user->nama;
                $dataKetepatan[] = $persen;
            }

            return view('dashboard', compact(
                'jumlahUser',
                'jumlahMesin',
                'totalPemeliharaanTerjadwal',
                'jadwalTerbaru',
                'jumlahRutin',
                'jumlahIncidental',
                'labelsTeknisi',
                'dataKetepatan'
            ));
        } elseif (Auth::user()->level === 'Teknisi') {
            $userId = Auth::id();

            $mesinTeknisi = TeknisiMesin::where('user_id', $userId)->count();

            $jadwalTeknisi = JadwalPemeliharaan::where('user_id', $userId)->count();
            $jadwalTerjadwal = JadwalPemeliharaan::where('user_id', $userId)
                ->where('status', 'Terjadwal')
                ->count();

            $jadwalTerbaru = JadwalPemeliharaan::with('mesin')
                ->where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            return view('teknisi.dashboard', compact(
                'mesinTeknisi',
                'jadwalTeknisi',
                'jadwalTerjadwal',
                'jadwalTerbaru'
            ));
        } else {
            return redirect('/unauthorized');
        }
    }
}
