<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Validacion;
use Illuminate\Support\Carbon;

class Cotizaciones extends Model
{
    use HasFactory;

    public function modalidad(){
        return $this->belongsTo(Modalidades::class,'modalidad_id','id');
    }
    public function puerto(){
        return $this->belongsTo(Puerto::class,'puerto_id','id');
    }
    public function cabecera(){
        return $this->hasMany(CabeceraTransaccion::class,'cotizacion_id','id');
    }
    public function ciudad(){
        return $this->belongsTo(Ciudad::class,'ciudad_id','id');
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
    public function especialista(){
        return $this->belongsTo(User::class,'especialista_id','id');
    }
    public function incoter(){
        return $this->belongsTo(Incoterm::class,'incoterms_id','id');
    }
    public function contenedores(){
        return $this->belongsToMany(Contenedores::class);
    }
    public function tarifa(){
        return $this->belongsTo(Tarifario::class,'tarifa_id','id');
    }
    public function incoterms(){
        return $this->belongsTo(Incoterms::class,'incoterms_id','id');
    }
    public function validacions(){
        return $this->hasMany(Validacion::class,'cotizacion_id','id');
    }
    public function accion(){
        return $this->hasMany(Accion::class,'cotizacion_id','id');
    }
    public function ajustes(){
        return $this->hasMany(AjusteCotizacion::class,'cotizacion_id','id');
    }
    public function impuesto(){
        return $this->hasMany(cotizacion_impuesto::class,'cotizacion_id','id');
    }

    public function getTimeAttribute($value){
        return Carbon::parse($value)->format('Y-m-d');
    }

}
