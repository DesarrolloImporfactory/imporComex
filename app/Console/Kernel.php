<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('user:estado')->dailyAt('13:00');
        $schedule->command('user:verificar')->dailyAt('13:00');
        $schedule->command('user:register')->dailyAt('13:00');
        $schedule->command('cotizacion:status')->dailyAt('13:00');
        $schedule->command('user:week')->dailyAt('13:00');
        $schedule->command('user:confirm')->dailyAt('13:00');
    }

    
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
