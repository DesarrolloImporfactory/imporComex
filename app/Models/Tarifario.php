<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarifario extends Model
{
    use HasFactory;
    protected $connection = 'imporcomex';
    public $timestamps = false;
    protected $fillable = [
        'transporte',
        'origen',
        'destino',
        'peso_min',
        'peso_max',
        'costo'
    ];
    public function cotizaciones()
    {
        return $this->hasMany(Cotizaciones::class, 'tarifa_id', 'id');
    }
}
