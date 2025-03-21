<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mesin;
use Illuminate\Http\Request;
use App\Models\JadwalPemeliharaan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data statistik yang sama untuk semua role
        $jumlahUser = User::count();
        $jumlahMesin = Mesin::count();
        $totalPemeliharaanTerjadwal = JadwalPemeliharaan::where('status', 'terjadwal')->count();

        // Tentukan view berdasarkan level pengguna
        if (Auth::user()->level === 'Administrator') {
            return view('dashboard', compact('jumlahUser', 'jumlahMesin', 'totalPemeliharaanTerjadwal'));
        } elseif (Auth::user()->level === 'Teknisi') {
            return view('teknisi.dashboard', compact('jumlahUser', 'jumlahMesin', 'totalPemeliharaanTerjadwal'));
        } else {
            return redirect('/unauthorized'); // Jika role tidak dikenali
        }
    }
}
