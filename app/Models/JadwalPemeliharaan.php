<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPemeliharaan extends Model
{
    use HasFactory;

    protected $table = 'jadwal_pemeliharaan';
    public $timestamps = true;

    protected $fillable = [
        'mesin_id',
        'user_id',
        'jenis',
        'tanggal',
        'deskripsi',
        'status',
        'pertanyaan',
        'foto_sebelum',
        'foto_sesudah',
        'video',
    ];

    // Relasi ke tabel mesin
    public function mesin()
    {
        return $this->belongsTo(Mesin::class, 'mesin_id');
    }

    // Relasi ke tabel pertanyaan (jika ada model Pertanyaan)
    public function pertanyaan()
    {
        return $this->hasOne(Pertanyaan::class, 'jadwal_pemeliharaan_id');
    }

    // Relasi ke tabel user (teknisi)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke tabel screening (kalau ada proses pengecekan sebelum/selama pemeliharaan)
    public function screening()
    {
        return $this->hasOne(Screening::class, 'jadwal_id');
    }
}
