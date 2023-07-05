<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variables extends Model
{
    use HasFactory;
    protected $connection = 'imporcomex';
    public $timestamps = false;
    protected $fillable = [
        'valor',
        'minimo',
        'modalidad_id',
        'operacion_id',
        'tipo',
        'nombre'
    ];

    public function modalidad()
    {
        return $this->belongsTo(Modalidades::class, 'modalidad_id', 'id');
    }
    public function operacion()
    {
        return $this->belongsTo(PuertoChina::class, 'operacion_id', 'id');
    }
}
