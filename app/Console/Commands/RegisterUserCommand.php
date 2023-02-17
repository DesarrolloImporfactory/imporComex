<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Notifications\NewUser;
use Illuminate\Support\Facades\Notification;

class RegisterUserCommand extends Command
{
    
    protected $signature = 'user:register';

    protected $description = 'Notificar al usuario tras 2 dias de su registro';

    
    public function handle()
    {
        $newDate = Carbon::now()->subDay(2)->format('Y-m-d');
        $usuarios = User::all();
        foreach ($usuarios as $usuario) {
            if($usuario->created_at == $newDate){
                Notification::route('mail', $usuario->email)->notify(new NewUser($usuario->name));
            }  
        }   
    }
}
