<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Screening extends Model
{
    use HasFactory;

    protected $table = 'screenings'; // Nama tabel di database

    protected $fillable = [
        'mesin_id',
        'teknisi_id',
        'admin_id',
        'tanggal_pemeriksaan',
        'status_operasional',
        'kode_error',
        'suara_anomali',
        'getaran_berlebih',
        'kebocoran',
        'terakhir_perawatan',
        'tindakan_rekomendasi',
        'catatan',
        'jawaban'
    ];

    // Relasi ke mesin
    public function mesin() {
        return $this->belongsTo(Mesin::class, 'mesin_id');
    }

    // Relasi ke teknisi
    public function teknisi() {
        return $this->belongsTo(User::class, 'teknisi_id');
    }

    // Relasi ke admin
    public function admin() {
        return $this->belongsTo(User::class, 'admin_id')->where('level', 'Administrator');
    }
    }
