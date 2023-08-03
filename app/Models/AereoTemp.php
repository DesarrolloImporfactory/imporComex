<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AereoTemp extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $connection = 'imporcomex';
    protected $fillable = [
        'usuario_id',
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

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id', 'id');
    }
}
