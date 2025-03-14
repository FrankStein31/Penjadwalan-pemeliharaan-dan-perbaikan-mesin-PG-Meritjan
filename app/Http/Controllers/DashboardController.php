<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mesin;

class DashboardController extends Controller
{
    public function index()
    {
        $jumlahUser = User::count();        // Hitung jumlah user
        $jumlahMesin = Mesin::count();      // Hitung jumlah mesin

        // Kirim semua data ke view dalam satu kali return
        return view('dashboard', compact('jumlahUser', 'jumlahMesin'));
    }
}
