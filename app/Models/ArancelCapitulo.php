<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArancelCapitulo extends Model
{
    use HasFactory;

    public function declaracionesEcuador(){
        return $this->hasMany(DeclaracionesEcuador::class,'arancelCapitulo_id','id');
    }

    public function arancelEcuador(){
        return $this->hasMany(ArancelEcuador::class,'arancelCapitulo_id','id');
    }

    public function arancelSeccion(){
        return $this->belongsTo(ArancelSecction::class,'arancelSeccion_id','id');
    }
}
