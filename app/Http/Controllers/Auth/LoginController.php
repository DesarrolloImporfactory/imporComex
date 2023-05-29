<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        User::where('id', $id)->update(['session' => $newDate]);
        //foreach para mapear la consulta anidada
        foreach ($usuarioRol->roles as $rol) {
            $usuario = $rol->name;
        }
        User::where('id', $id)->update(['email_verified_at' => $newDate]);
       
        if ($usuario == "Admin") {

            return '/home';
        } else {
            return '/calculadoras';
        }
    }

    public function redirectUser(string $id){
        $sessionData = DB::table('sessions')->where('id', $id)->first();
        Auth::loginUsingId($sessionData->user_id);
        return redirect('home');
    }
}
