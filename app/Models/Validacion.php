<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Validacion extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre_pro',
        'contacto',
        'enlace',
        'foto',
        'cotizacion_id',
    ];
    public function cotizacion(){
        return $this->belongsTo(Cotizaciones::class,'cotizacion_id','id');
    }
}
