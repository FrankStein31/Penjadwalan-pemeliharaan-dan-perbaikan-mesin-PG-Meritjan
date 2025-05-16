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
    ];

    public function mesin()
    {
        return $this->belongsTo(Mesin::class, 'mesin_id');
    }

    public function station()
    {
        return $this->belongsTo(Station::class, 'station_id');
    }

    public function sparePart()
    {
        return $this->belongsTo(SparePart::class);
    }
}
