<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incoterms extends Model
{
    use HasFactory;
    protected $connection = 'imporcomex';

    public function cotizaciones(){
        return $this->hasMany(Cotizaciones::class,'incoterms_id','id');
    }

    public function puertos(){
        return $this->belongsTo(PuertoChina::class,'incoterms_id','id');
    }
}
