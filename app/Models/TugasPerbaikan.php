<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasPerbaikan extends Model
{
    use HasFactory;

    protected $table = 'repair_assignments';
    protected $fillable = [
        'mesin_id',
        'user_id',
        'assigned_at',
        'status',
    ];

    // Relasi ke tabel Machines
    public function machine()
    {
        return $this->belongsTo(Mesin::class, 'mesin_id');
    }

    // Relasi ke tabel Users (Teknisi)
    public function technician()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
