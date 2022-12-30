<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incoterm extends Model
{
    use HasFactory;

    public function cotizaciones(){
        return $this->hasMany(Cotizaciones::class,'incoterms_id','id');
    }

    public function coIndividual(){
        return $this->hasMany(CoIndividual::class,'incoterms_id','id');
    }


}
