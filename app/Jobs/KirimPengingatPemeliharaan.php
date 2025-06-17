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
        // ✅ Bagian 1: Jadwal Terjadwal → update jika tanggal terlewat
        $jadwals = JadwalPemeliharaan::with('user', 'mesin')
            ->where('status', 'Terjadwal')
            ->get();

        foreach ($jadwals as $jadwal) {
            $tanggalJadwal = Carbon::parse($jadwal->tanggal);
            $tanggalAsli = $tanggalJadwal->copy();
            $perluKirimNotif = false;

            if ($tanggalJadwal->isPast()) {
                // Cek apakah tanggal JADWAL sudah sesuai bulan & tahun sekarang
                if ($tanggalJadwal->month !== now()->month || $tanggalJadwal->year !== now()->year) {
                    $tanggalBaru = $tanggalJadwal->copy()
                        ->setMonth(now()->month)
                        ->setYear(now()->year);
                    $jadwal->update(['tanggal' => $tanggalBaru]);
                    $tanggalJadwal = $tanggalBaru;
                    $perluKirimNotif = true;

                    \Log::info("Jadwal ID {$jadwal->id} diupdate dari {$tanggalAsli->format('Y-m-d')} ke {$tanggalBaru->format('Y-m-d')}");
                }
            }
            $hariSisa = now()->diffInDays($tanggalJadwal, false);

            if ($perluKirimNotif) {
                $this->kirimNotifikasi($jadwal, $tanggalJadwal, $hariSisa, true);
            }
            elseif ($hariSisa >= 1 && $hariSisa <= 3) {
                $this->kirimNotifikasi($jadwal, $tanggalJadwal, $hariSisa, false);
            }
        }

        // ✅ Bagian 2: Jadwal Selesai atau Dibatalkan → reset jika bulan sudah lewat
        $resetJadwals = JadwalPemeliharaan::with('user', 'mesin')
            ->whereIn('status', ['Selesai', 'Dibatalkan'])
            ->get();

        foreach ($resetJadwals as $jadwal) {
            $tanggal = Carbon::parse($jadwal->tanggal);
            $bulanJadwal = $tanggal->month;
            $tahunJadwal = $tanggal->year;

            $bulanSekarang = now()->month;
            $tahunSekarang = now()->year;

            if ($bulanJadwal < $bulanSekarang || $tahunJadwal < $tahunSekarang) {
                // Ganti bulan dan tahun, tapi tetap pakai hari yang sama
                $tanggalBaru = Carbon::create(
                    $tahunSekarang,
                    $bulanSekarang,
                    $tanggal->day,
                    $tanggal->hour,
                    $tanggal->minute,
                    $tanggal->second
                );

                // Pastikan tanggal valid (misalnya jika hari 31 tapi bulan ini hanya 30 hari)
                if ($tanggalBaru->month !== $bulanSekarang) {
                    $tanggalBaru = $tanggalBaru->subDay(); // Kurangi 1 hari jika tidak valid
                }

                $jadwal->update([
                    'status' => 'Terjadwal',
                    'tanggal' => $tanggalBaru,
                ]);

                \Log::info("Jadwal ID {$jadwal->id} direset ke Terjadwal dengan tanggal baru {$tanggalBaru->format('Y-m-d')}");

                // ✅ PERBAIKAN: Kirim notifikasi WhatsApp untuk jadwal yang direset
                if ($jadwal->user) {
                    $hariSisa = now()->diffInDays($tanggalBaru, false);
                    $this->kirimNotifikasi($jadwal, $tanggalBaru, $hariSisa, true, true); // Parameter ke-5 untuk jadwal reset
                }
            }
        }
    }

    private function kirimNotifikasi($jadwal, $tanggalJadwal, $hariSisa, $isUpdatedSchedule = false, $isResetSchedule = false)
    {
        $teknisi = $jadwal->user;
        $token = "RQCD2A7WMdZHJfEYDTDK";
        $target = $teknisi->telp;

        $tanggalFormatted = $tanggalJadwal->format('d-m-Y H:i');

        if ($isResetSchedule) {
            // Pesan khusus untuk jadwal yang direset dari Selesai/Dibatalkan
            $pengingat = "Jadwal pemeliharaan telah dibuat untuk bulan ini";
            $emoji = "🔄";
            $header = "Jadwal Pemeliharaan Bulan Baru";
        } elseif ($isUpdatedSchedule) {
            // Pesan khusus untuk jadwal yang baru diupdate
            $pengingat = "Jadwal pemeliharaan Anda telah diperbarui ke bulan berikutnya";
            $emoji = "🔄";
            $header = "Pembaruan Jadwal Pemeliharaan";
        } else {
            // Pesan normal untuk reminder
            $pengingat = "$hariSisa hari lagi";
            $emoji = "📢";
            $header = "Reminder Jadwal Pemeliharaan";
        }

        $pesan = "$emoji *$header*\n\n"
            . "Halo *{$teknisi->nama}*,\n";

        if ($isResetSchedule) {
            $pesan .= "Jadwal pemeliharaan untuk bulan ini telah dibuat otomatis karena jadwal sebelumnya sudah selesai/dibatalkan.\n\n";
        } elseif ($isUpdatedSchedule) {
            $pesan .= "Jadwal pemeliharaan mesin Anda telah diperbarui otomatis karena jadwal sebelumnya sudah terlewat.\n\n";
        } else {
            $pesan .= "Ini adalah pengingat bahwa Anda memiliki jadwal pemeliharaan mesin dalam waktu dekat.\n\n";
        }

        $pesan .= "🔧 *Detail Jadwal:*\n"
            . "📅 Tanggal: $tanggalFormatted\n"
            . "🛠️ Mesin: {$jadwal->mesin->nama}\n"
            . "📂 Jenis: " . ucfirst($jadwal->jenis) . "\n\n";

        if ($isResetSchedule || $isUpdatedSchedule) {
            $pesan .= "📌 *Jadwal baru Anda adalah $tanggalFormatted*\n"
                . "⏳ Mohon siapkan keperluan yang dibutuhkan.\n\n";
        } else {
            $pesan .= "⏳ *$pengingat*, mohon siapkan keperluan yang dibutuhkan.\n\n";
        }

        $pesan .= "Terima kasih atas kerja samanya.";

        // Kirim melalui Fonnte
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

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        // Log untuk tracking
        $tipeNotif = $isResetSchedule ? 'reset' : ($isUpdatedSchedule ? 'update' : 'reminder');
        \Log::info("Notifikasi {$tipeNotif} dikirim ke {$teknisi->nama} ({$target}) untuk jadwal ID {$jadwal->id}. HTTP Code: $httpCode");
    }
}
