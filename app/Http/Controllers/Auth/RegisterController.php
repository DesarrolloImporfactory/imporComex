<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Idioma;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
   
    
    use RegistersUsers;

    protected $redirectTo = '/login';
    //protected $redirectTo = RouteServiceProvider::HOME;

   
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'telefono'=>['required'],
            'date'=>['required'],
            'importacion'=>['required'],
            'idioma'=>['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

   
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'telefono' => $data['telefono'],
            'date' => $data['date'],
            'importacion' => $data['importacion'],
            'idioma' => $data['idioma'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ])->assignRole('client');
    }
}
