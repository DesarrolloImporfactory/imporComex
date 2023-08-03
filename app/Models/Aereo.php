<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aereo extends Model
{
     use HasFactory;
    public $timestamps = false;
    protected $connection = 'imporcomex';
    protected $fillable = [
        'cotizacion_id',
        'cartones',
        'largo',
        'ancho',
        'alto',
        'peso_volumetrico_pieza',
        'peso_volumetrico_total',
        'peso_bruto_carton',
        'peso_bruto_piezas',
        'total'
    ];

    public function cotizacion()
    {
        return $this->belongsTo(Cotizaciones::class, 'cotizacion_id', 'id');
    }
}
