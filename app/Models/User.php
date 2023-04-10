<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\UserResetPassword;
use App\Notifications\VerifyEmails;
use Illuminate\Support\Carbon;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

     
    
    public function cotizaciones(){
        return $this->hasMany(Cotizaciones::class,'usuario_id','id');
    }
    public function coIndividual(){
        return $this->hasMany(CoIndividual::class,'usuario_id','id');
    }

    public function impuesto(){
        return $this->hasMany(cotizacion_impuesto::class,'usuario_id','id');
    }
    public function getSessionAttribute($value){
        return Carbon::parse($value)->format('Y-m-d');
    }
    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->format('Y-m-d');
    }
    public function getUpdatedAtAttribute($value){
        return Carbon::parse($value)->format('Y-m-d');
    }
    public function getVerifiedAttribute($value){
        return Carbon::parse($value)->format('Y-m-d H');
    }

    protected $fillable = [
        'name',
        'email',
        'telefono',
        'date',
        'importacion',
        'idioma',
        'estado',
        'cedula',
        'ruc',
        'password',
        'email_verified_at',
    ];

    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new UserResetPassword($token));
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmails);
    }
    public function adminlte_profile_url()
     {
         return 'admin/perfil';
     }
}
