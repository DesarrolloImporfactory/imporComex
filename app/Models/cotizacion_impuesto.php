<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cotizacion_impuesto extends Model
{
    use HasFactory;
    public function usuario(){
        return $this->belongsTo(User::class,'usuario_id','id');
    }
    public function cotizacion(){
        return $this->belongsTo(Cotizaciones::class,'cotizacion_id','id');
    }
    public function impuesto(){
        return $this->belongsTo(Impuesto::class,'impuesto_id','id');
    }

}
