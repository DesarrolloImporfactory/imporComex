<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    use HasFactory;
    protected $fillable = [
        'cod_provincia',
        'cod_canton',
        'nombre_provincia',
        'nombre_canton'
    ];

    public function cotizaciones()
    {
        return $this->hasMany(Cotizaciones::class, 'ciudad_id', 'id');
    }
}
