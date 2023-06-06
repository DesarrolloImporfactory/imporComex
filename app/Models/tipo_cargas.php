<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tipo_cargas extends Model
{
    use HasFactory;
    protected $connection = 'imporcomex';

    public function cotizaciones(){
        return $this->hasMany(Cotizaciones::class,'cargas_id','id');
    }
}
