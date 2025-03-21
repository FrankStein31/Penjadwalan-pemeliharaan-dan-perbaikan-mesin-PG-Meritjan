<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;

    protected $fillable = ['nama_station'];

    public function mesins()
    {
        return $this->hasMany(Mesin::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
} 