<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalculadoraTemporal extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $connection = 'imporcomex';
    protected $fillable = [
        'usuario_id',
        'insumo_id',
        'cartones',
        'largo',
        'ancho',
        'alto',
        'total'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id', 'id');
    }
    public function producto()
    {
        return $this->belongsTo(Insumo::class, 'insumo_id', 'id');
    }
}
