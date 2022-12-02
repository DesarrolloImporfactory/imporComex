<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizaciones extends Model
{
    use HasFactory;

    public function modalidad(){
        return $this->belongsTo(Modalidades::class,'modalidad_id','id');
    }
    public function pais(){
        return $this->belongsTo(Paises::class,'pais_id','id');
    }
    public function carga(){
        return $this->belongsTo(tipo_cargas::class,'cargas_id','id');
    }
    public function usuario(){
        return $this->belongsTo(User::class,'usuario_id','id');
    }

    public function incoter(){
        return $this->belongsTo(Incoterm::class,'incoterms_id','id');
    }
    public function contenedor(){
        return $this->belongsTo(Contenedores::class,'contenedor_id','id');
    }
    public function tarifa(){
        return $this->belongsTo(tarifaGruapl::class,'tarifa_id','id');
    }

}
