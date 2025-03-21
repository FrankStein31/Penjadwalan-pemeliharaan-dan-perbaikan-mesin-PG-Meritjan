<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeknisiMesin extends Model
{
    use HasFactory;

    protected $table = 'teknisi_mesin';
    protected $fillable = ['mesin_id', 'user_id'];

    public function teknisi()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mesin()
    {
        return $this->belongsTo(Mesin::class, 'mesin_id');
    }
}
