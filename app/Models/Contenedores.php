<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contenedores extends Model
{
    use HasFactory;
   
    public function cotizaciones(){
        return $this->belongsToMany(Cotizaciones::class,'contenedor_cotizacion');
    }
    
    public function estado(){
        return $this->belongsTo(Estado::class,'estado_id','id');
    }
}
