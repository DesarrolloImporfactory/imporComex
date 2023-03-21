<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regimen extends Model
{
    use HasFactory;
    
    public function declaracionesEcuador(){
        return $this->hasMany(DeclaracionesEcuador::class,'regimen_id','id');
    }
}
