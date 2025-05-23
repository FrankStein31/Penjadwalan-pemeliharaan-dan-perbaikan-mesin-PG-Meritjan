<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    use HasFactory;
  protected $table = 'pertanyaan';
    protected $fillable = [
        'jadwal_pemeliharaan_id',
        'getaran',
        'suara',
        'pelumasan',
        'bocor',
        'kerusakan',
        'tindakan',
    ];

    // Relasi ke Jadwal Perbaikan
    public function jadwal()
    {
        return $this->belongsTo(JadwalPemeliharaan::class, 'jadwal_pemeliharaan_id');
    }
}
