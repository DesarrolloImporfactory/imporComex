<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaisEmbarque extends Model
{
    use HasFactory;

    public function declaracionesEcuador(){
        return $this->hasMany(DeclaracionesEcuador::class,'paisEmbarque_id','id');
    }
}
