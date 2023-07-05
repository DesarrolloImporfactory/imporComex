<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuertoChina extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $connection = 'imporcomex';
    protected $fillable = [
        'name',
    ];

    public function incoterms(){
        return $this->hasMany(Incoterms::class,'incoterms_id','id');
    }
}
