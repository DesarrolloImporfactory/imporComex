<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use Carbon\Carbon;

class LoginController extends Controller
{
    

    use AuthenticatesUsers;

    
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectPath()
    {
        
        $id = auth()->user()->id;
        $usuarioRol = User::with('roles')->findOrFail($id);
         $newDate = Carbon::now();
         User::where('id',$id)->update(['session'=>$newDate]);
        //foreach para mapear la consulta anidada
        foreach ($usuarioRol->roles as $rol) {
            $usuario = $rol->name;
        }
        if($usuario == "Admin"){
            
            return '/home';
        }else{
            return '/home';
        }

    }
}
