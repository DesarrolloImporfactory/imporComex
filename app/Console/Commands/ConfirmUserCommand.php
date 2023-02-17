<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\OnBoarding;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class ConfirmUserCommand extends Command
{
    
    protected $signature = 'user:confirm';

    
    protected $description = 'Notificar al usuario 1 hora despues de verificar su cuenta';

    public function handle()
    {
        $newDate = Carbon::now()->subHour(1)->format('Y-m-d H');
        $usuarios = User::all();
        foreach ($usuarios as $usuario) {
            if($usuario->verified == $newDate){
                Notification::route('mail', $usuario->email)->notify(new OnBoarding($usuario->name));
            }
        }
    }
}
