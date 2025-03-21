<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class MesinSparePart extends Pivot
{
    use HasFactory;

    protected $table = 'mesin_spare_part'; // Nama tabel pivot

    protected $fillable = [
        'mesin_id',
        'spare_part_id',
        'jumlah'
    ];
}
