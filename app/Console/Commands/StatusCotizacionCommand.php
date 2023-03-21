<?php

namespace App\Console\Commands;

use App\Models\Cotizaciones as ModelsCotizaciones;
use App\Notifications\FirstStep;
use App\Notifications\SecondStep;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use App\Notifications\WeekUser;

class StatusCotizacionCommand extends Command
{

    protected $signature = 'cotizacion:status';

    protected $description = 'Notifica al usuario el estado de su cotizacion';


    public function handle()
    {
        $newDate = Carbon::now()->subDay(2)->format('Y-m-d');
        $cotizaciones = ModelsCotizaciones::with('usuario')->get();
        $usuario='Isaiassss';
        foreach ($cotizaciones as $cotizacion) {
            if($cotizacion->proceso == 2 && $newDate == $cotizacion->time){
                Notification::route('mail',$cotizacion->usuario->email)->notify(new FirstStep($cotizacion->usuario->name));
            }else if($cotizacion->proceso == 3 && $newDate == $cotizacion->time){
                Notification::route('mail',$cotizacion->usuario->email)->notify(new SecondStep($cotizacion->usuario->name));
            }
            
        }
    }
}
