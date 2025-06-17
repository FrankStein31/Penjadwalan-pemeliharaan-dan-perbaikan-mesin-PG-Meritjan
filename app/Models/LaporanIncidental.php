<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanIncidental extends Model
{
    use HasFactory;

    protected $table = 'laporanincidental';

    protected $fillable = [
        'mesin_id',
        'station_id',
        'description',
        'photo_path',
        'requires_spare_part',
        'spare_part_id',
        'status',
        'user_id', // ✅ tambahkan agar bisa mass-assigned
    ];

    // Relasi ke mesin
    public function mesin()
    {
        return $this->belongsTo(Mesin::class, 'mesin_id');
    }

    // Relasi ke station
    public function station()
    {
        return $this->belongsTo(Station::class, 'station_id');
    }

    // Relasi ke spare part
    public function sparePart()
    {
        return $this->belongsTo(SparePart::class, 'spare_part_id');
    }

    // ✅ Relasi ke user/teknisi pembuat laporan
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
