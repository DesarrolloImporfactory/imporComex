<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleTransaccion extends Model
{
    use HasFactory;
    protected $connection = 'imporcomex';
    public function cabecera(){
        return $this->belongsTo(CabeceraTransaccion::class,'cabecera_id','id');
    }
    public function pago(){
        return $this->belongsTo(FormaPago::class,'pago_id','id');
    }
    public function transaccion(){
        return $this->belongsTo(Transaccion::class,'transaccion_id','id');
    }
}
