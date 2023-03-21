<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoInsumo extends Model
{
    use HasFactory;

    protected $fillable = [
        'cotizacion_id',
        'insumo_id',
        'cantidad',
        'precio',
        'fob',
        'seguro',
        'flete',
        'cif',
        'advalore',
        'porcentaje',
        'fodinfa',
        'iva',
        'total'
    ];

    public function insumo(){
        return $this->belongsTo(Insumo::class,'insumo_id','id');
    }
    public function proveedor(){
        return $this->belongsTo(Validacion::class,'proveedor_id','id');
    }
}
