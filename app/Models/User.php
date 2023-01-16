<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\UserResetPassword;

class User extends Authenticatable
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
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new UserResetPassword($token));
    }
}
