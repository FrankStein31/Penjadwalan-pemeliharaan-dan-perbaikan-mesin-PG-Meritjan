<?php

namespace App\Jobs;

use App\Models\JadwalPemeliharaan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class KirimPengingatPemeliharaan implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        // Ambil semua jadwal dalam 1-3 hari ke depan
        $jadwals = JadwalPemeliharaan::with('user', 'mesin')
            ->whereDate('tanggal', '>=', now()->addDays(1)->startOfDay())
            ->whereDate('tanggal', '<=', now()->addDays(3)->endOfDay())
            ->where('status', 'Terjadwal')
            ->get();

        foreach ($jadwals as $jadwal) {
            $teknisi = $jadwal->user;
            $token = "RWQHVXjZJS2nuH698t7C";
            $target = $teknisi->telp;

            $tanggalFormatted = Carbon::parse($jadwal->tanggal)->format('d-m-Y H:i');
            $hariSisa = now()->diffInDays($jadwal->tanggal, false);
            $pengingat = $hariSisa > 0 ? "$hariSisa hari lagi" : "Hari ini";

            $pesan = "📢 *Reminder Jadwal Pemeliharaan*\n\n"
                . "Halo *{$teknisi->nama}*,\n"
                . "Ini adalah pengingat bahwa Anda memiliki jadwal pemeliharaan mesin dalam waktu dekat.\n\n"
                . "🔧 *Detail Jadwal:*\n"
                . "📅 Tanggal: $tanggalFormatted\n"
                . "🛠️ Mesin: {$jadwal->mesin->nama}\n"
                . "📂 Jenis: " . ucfirst($jadwal->jenis) . "\n\n"
                . "⏳ *$pengingat*, mohon siapkan keperluan yang dibutuhkan.\n\n"
                . "Terima kasih atas kerja samanya.";

            // Kirim ke Fonnte
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => [
                    'target' => $target,
                    'message' => $pesan,
                ],
                CURLOPT_HTTPHEADER => [
                    "Authorization: $token"
                ],
            ]);
            curl_exec($curl);
            curl_close($curl);
        }
    }
}
