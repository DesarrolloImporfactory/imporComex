<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeclaracionesEcuador extends Model
{
    use HasFactory;

    public function paisEmbarque(){
        return $this->belongsTo(PaisEmbarque::class,'paisEmbarque_id','id');
    }

    public function regimen(){
        return $this->belongsTo(Regimen::class,'regimen_id','id');
    }

    public function fecha(){
        return $this->belongsTo(Fecha::class,'fecha_id','id');
    }

    public function estadoDeclaracion(){
        return $this->belongsTo(EstadoDeclaracion::class,'estDeclaracion_id','id');
    }

    public function ciudadEmbarque(){
        return $this->belongsTo(CiudadEmbarque::class,'ciudadEmbar_id','id');
    }

    public function agencia(){
        return $this->belongsTo(Agencia::class,'agencia_id','id');
    }

    public function arancelPartida(){
        return $this->belongsTo(ArancelPartida::class,'arancelPartida_id','id');
    }

    public function arancelCapitulo(){
        return $this->belongsTo(ArancelCapitulo::class,'arancelCapitulo_id','id');
    }
}
