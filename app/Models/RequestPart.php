<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestPart extends Model
{
    protected $fillable = [
        'teknisi_id',
        'mesin_id',
        'spare_part_id',
        'jumlah',
        'keterangan',
        'status',
    ];

    public function teknisi()
    {
        return $this->belongsTo(User::class, 'teknisi_id');
    }

    public function sparePart()
    {
        return $this->belongsTo(SparePart::class, 'spare_part_id');
    }

    public function mesin()
    {
        return $this->belongsTo(Mesin::class, 'mesin_id');
    }
}
