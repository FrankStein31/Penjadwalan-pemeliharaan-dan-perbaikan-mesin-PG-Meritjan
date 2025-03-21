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
        'status'
    ];

    // Relasi ke tabel mesin
    public function mesin()
    {
        return $this->belongsTo(Mesin::class, 'mesin_id');
    }

    // Relasi ke tabel user (teknisi)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
