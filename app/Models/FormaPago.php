<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormaPago extends Model
{
    use HasFactory;
    protected $connection = 'imporcomex';
    public function detalle(){
        return $this->hasMany(DetalleTransaccion::class,'pago_id','id');
    }
}
