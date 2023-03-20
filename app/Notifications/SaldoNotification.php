<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;
use App\Models\CabeceraTransaccion;

class SaldoNotification extends Notification
{
    use Queueable;
    public $id;

    public function __construct(String $id)
    {
        $this->id = $id;
    }


    public function via($notifiable)
    {
        return ['mail'];
    }


    public function toMail($notifiable)
    {
        $data = User::findOrFail($this->id);

        $cuentas = CabeceraTransaccion::with([
            'cotizacion' => function ($q) {
                $q->with(['usuario' => function ($q) {
                }]);
            }
        ])->where('id', $this->id)->first();
        $name = $cuentas->cotizacion->usuario->name;
        $credito = $cuentas->cotizacion->total;
        $saldo = $cuentas->saldo ;
        return (new MailMessage)
            ->subject('Estado de cuenta. ')
            ->greeting('Hola ' . $name. '! ')
            ->line('Te notificamos tu estado de cuenta de la cotizacion. ')
            ->line('Valor del credito: '. $credito)
            ->line('Valor del saldo: '. $saldo)
            ->action('Ingresar', url('/'))
            ->salutation('Conatacte con ellos ahora! ');
    }


    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
