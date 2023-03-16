<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CabeceraTransaccion extends Model
{
    use HasFactory;
    // protected $fillable = [
    //     'cotizacion_id',
    //     'fecha_cotizacion',
    //     'estado',
    // ];
    public function detalle(){
        return $this->hasMany(DetalleTransaccion::class,'cabecera_id','id');
    }
    public function cotizacion(){
        return $this->belongsTo(Cotizaciones::class,'cotizacion_id','id');
    }
}
