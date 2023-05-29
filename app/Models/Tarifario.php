<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarifario extends Model
{
    use HasFactory;

    public function cotizaciones(){
        return $this->hasMany(Cotizaciones::class,'tarifa_id','id');
    }
}
