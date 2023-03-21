<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'cantidad', 'precio','porcentaje'];

    public function productoInsumo(){
        return $this->hasMany(ProductoInsumo::class,'insumo_id','id');
    }
}
