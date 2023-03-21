<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArancelSecction extends Model
{
    use HasFactory;

    public function arancelCapitulo(){
        return $this->hasMany(ArancelCapitulo::class,'arancelSeccion_id','id');
    }
}
