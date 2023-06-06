<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Impuesto extends Model
{
    use HasFactory;
    protected $connection = 'imporcomex';
    
    public function impuesto(){
        return $this->hasMany(Impuesto::class,'impuesto_id','id');
    }
}
