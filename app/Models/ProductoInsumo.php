<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoInsumo extends Model
{
    use HasFactory;
    protected $fillable = ['cotizacion_id', 'insumo_id', 'cantidad','precio','porcentaje'];
}
