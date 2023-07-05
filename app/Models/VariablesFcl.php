<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariablesFcl extends Model
{
    use HasFactory;
    protected $connection = 'imporcomex';
    public $timestamps = false;
}
