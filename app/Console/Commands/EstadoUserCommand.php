<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\User;

class EstadoUserCommand extends Command
{
   
    protected $signature = 'user:estado';

    
    protected $description = 'Cambia el estado del usuario cuando no haya iniciado session por un lapso de tiempo';

    
    public function handle()
    {
        //$newDate = Carbon::now()->subMinutes(5);
        $newDate = Carbon::now()-> subHour(1);
       
        User::where('session','<=',$newDate)->update(['estado'=>0]);
    }
}
