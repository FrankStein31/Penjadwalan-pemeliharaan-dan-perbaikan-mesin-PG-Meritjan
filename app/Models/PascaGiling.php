<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PascaGiling extends Model
{
    use HasFactory;

    protected $fillable = [
        'station_id',
        'mesin_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'deskripsi',
        'status',
    ];

    // Relasi ke Mesin
    public function mesin()
    {
        return $this->belongsTo(Mesin::class);
    }

    // Relasi ke Station
    public function station()
    {
        return $this->belongsTo(Station::class);
    }
}
