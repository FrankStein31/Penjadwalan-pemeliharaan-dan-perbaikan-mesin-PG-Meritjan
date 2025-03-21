<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mesin;
use Illuminate\Http\Request;
use App\Models\JadwalPemeliharaan;
use App\Models\TeknisiMesin;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data berdasarkan level pengguna
        if (Auth::user()->level === 'Administrator') {
            // Admin melihat semua data
            $jumlahUser = User::count();
            $jumlahMesin = Mesin::count();
            $totalPemeliharaanTerjadwal = JadwalPemeliharaan::where('status', 'Terjadwal')->count();
            $jadwalTerbaru = JadwalPemeliharaan::with(['mesin', 'user'])
                                ->orderBy('created_at', 'desc')
                                ->take(5)
                                ->get();

            return view('dashboard', compact(
                'jumlahUser', 
                'jumlahMesin', 
                'totalPemeliharaanTerjadwal',
                'jadwalTerbaru'
            ));
        } elseif (Auth::user()->level === 'Teknisi') {
            // Teknisi hanya melihat data terkait dirinya
            $userId = Auth::id();
            
            // Hitung mesin yang ditangani teknisi ini
            $mesinTeknisi = TeknisiMesin::where('user_id', $userId)->count();
            
            // Hitung jadwal pemeliharaan untuk teknisi ini
            $jadwalTeknisi = JadwalPemeliharaan::where('user_id', $userId)->count();
            $jadwalTerjadwal = JadwalPemeliharaan::where('user_id', $userId)
                                ->where('status', 'Terjadwal')
                                ->count();
            
            // Ambil jadwal terbaru teknisi
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
            return redirect('/unauthorized'); // Jika role tidak dikenali
        }
    }
}
