<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SparePart extends Model
{
    use HasFactory;

    protected $table = 'spare_parts'; // Nama tabel di database

    protected $fillable = [
        'kode_part',
        'nama',
        'jenis',
        'stok',
        'deskripsi'
        ];

    public function mesins()
    {
        return $this->belongsToMany(Mesin::class, 'mesin_spare_part')
                    ->withPivot('jumlah')
                    ->withTimestamps();
    }
}
