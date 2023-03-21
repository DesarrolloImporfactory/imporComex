<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\EstadoNotification;

class ActividadUserCommand extends Command
{
    
    protected $signature = 'user:verificar';

   
    protected $description = 'Verifica la inactividad del usuario tras 3 dias de inactividad';

    
    public function handle()
    {
        $newDate = Carbon::now()->subDay(3)->format('Y-m-d');
        //$usuarios = User::where('session','=', $newDate)->get();
        $usuarios = User::all();
        foreach ($usuarios as $usuario) {
            if($usuario->session == $newDate){
                Notification::route('mail', $usuario->email)->notify(new EstadoNotification($usuario->name));
            }   
        }
    }
}
