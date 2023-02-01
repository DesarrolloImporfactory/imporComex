<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArancelEcuador extends Model
{
    use HasFactory;

    public function arancelCapitulo(){
        return $this->belongsTo(ArancelCapitulo::class,'arancelCapitulo_id','id');
    }

    public function arancelPartida(){
        return $this->belongsTo(ArancelPartida::class,'arancelPartida_id','id');
    }
}
