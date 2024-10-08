<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modalidades extends Model
{
    use HasFactory;
    protected $connection = 'imporcomex';

    public function cotizaciones(){
        return $this->hasMany(Cotizaciones::class,'modalidad_id','id');
    }
}
