<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contenedores extends Model
{
    use HasFactory;
    public function cotizaciones(){
        return $this->hasMany(Cotizaciones::class,'contenedor_id','id');
    }
}
