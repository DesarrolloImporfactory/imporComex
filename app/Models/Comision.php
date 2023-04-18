<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comision extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'valor',
        'valor_min',
        'valor_max',
    ];
}
