<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArancelPartida extends Model
{
    use HasFactory;

    public function declaracionesEcuador(){
        return $this->hasMany(DeclaracionesEcuador::class,'arancelPartida_id','id');
    }

    public function arancelEcuador(){
        return $this->hasMany(ArancelEcuador::class,'arancelPartida_id','id');
    }
}
