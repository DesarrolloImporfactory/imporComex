<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoIndividual extends Model
{
    use HasFactory;
    public function origen(){
        return $this->belongsTo(Paises::class,'origen_id','id');
    }
    public function destino(){
        return $this->belongsTo(Paises::class,'destino_id','id');
    }
    public function incoter(){
        return $this->belongsTo(Incoterm::class,'incoterms_id','id');
    }

    public function usuario(){
        return $this->belongsTo(User::class,'usuario_id','id');
    }
    public function especialista(){
        return $this->belongsTo(User::class,'especialista_id','id');
    }
}
