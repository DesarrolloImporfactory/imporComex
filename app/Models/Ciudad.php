<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function cotizaciones()
    {
        return $this->hasMany(Cotizaciones::class, 'ciudad_id', 'id');
    }
}
