<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calculadora extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $connection = 'imporcomex';
    protected $fillable = [
        'cotizacion_id',
        'insumo_id',
        'cartones',
        'largo',
        'ancho',
        'alto',
        'total'
    ];

    public function cotizacion()
    {
        return $this->belongsTo(Cotizaciones::class, 'cotizacion_id', 'id');
    }
    public function producto()
    {
        return $this->belongsTo(Insumo::class, 'insumo_id', 'id');
    }
}
