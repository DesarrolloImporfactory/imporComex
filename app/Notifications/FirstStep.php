<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FirstStep extends Notification
{
    use Queueable;
    protected $usuario;
    

    public function __construct($usuario)
    {
        $this->usuario = $usuario;//consultar  por el id 
    }


    public function via($notifiable)
    {
        return ['mail'];
    }


    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Termina lo que iniciaste. ')
            ->greeting('Hola ' . $this->usuario . '! ')
            ->line('Ya diste el primer paso, para realizar tu importacion y hacerlo de manera exitosa.')
            ->line('necesitamos un par de detalles mas, para sacar un costeo final de tus productos')
            ->action('Ingresar', url('/imporComex/public/login'))
            ->line('si tienes algun problema de informacion, puedes conectarte directamente un uno de nuestros expertos, para que te guien.')
            ->salutation('Haz de tu importacion una realidad! ');
    }


    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
