<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    use HasFactory;
    protected $connection = 'imporcomex';
    protected $fillable = ['nombre', 'cantidad', 'precio','porcentaje'];

    public function productoInsumo(){
        return $this->hasMany(ProductoInsumo::class,'insumo_id','id');
    }
    
    public function usuario(){
        return $this->belongsTo(User::class,'usuario_id','id');
    }
    // public function calculos(){
    //     return $this->hasOne(Calculadora::class,'insumo_id','id');
    // }
}
