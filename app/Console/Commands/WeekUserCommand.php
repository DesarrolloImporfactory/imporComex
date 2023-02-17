<?php

namespace App\Console\Commands;

use App\Notifications\WeekUser;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use App\Models\User;

class WeekUserCommand extends Command
{
    
    protected $signature = 'user:week';

    
    protected $description = 'Notificar al usuario tras 1 semana de su registro';

    
    public function handle()
    {
        $newDate = Carbon::now()->subDays(7)->format('Y-m-d');
        $usuarios = User::all();
        foreach ($usuarios as $usuario) {
            if($usuario->created_at == $newDate){
                Notification::route('mail', $usuario->email)->notify(new WeekUser($usuario->name));
            }
        }
    }
}
