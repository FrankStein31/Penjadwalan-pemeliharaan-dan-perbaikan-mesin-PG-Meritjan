<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeknisiMesin extends Model
{
    use HasFactory;

    protected $table = 'teknisi_mesin';
    protected $fillable = ['user_id', 'mesin_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mesin()
    {
        return $this->belongsTo(Mesin::class);
    }

    // Tambahan untuk akses station melalui mesin atau user
    public function stationMesin()
    {
        return $this->mesin->station();
    }
}
