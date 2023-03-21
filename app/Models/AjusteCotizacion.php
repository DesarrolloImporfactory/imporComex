<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AjusteCotizacion extends Model
{
    use HasFactory;
    public function cotizacion(){
        return $this->belongsTo(Cotizaciones::class,'cotizacion_id','id');
    }
}
