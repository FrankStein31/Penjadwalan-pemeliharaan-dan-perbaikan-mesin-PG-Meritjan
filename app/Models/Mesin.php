<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesin extends Model
{
    use HasFactory;
    protected $table = 'mesins';
    protected $fillable = [
        'nama',
        'jenis',
        'tahun',
        'deskripsi',
        'station_id'
    ];
    public function station()
    {
        return $this->belongsTo(Station::class);
    }
}
