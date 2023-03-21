<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SecondStep extends Notification
{
    use Queueable;
    protected $usuario;
    
    public function __construct(String $usuario)
    {
        $this->usuario = $usuario;
    }

    
    public function via($notifiable)
    {
        return ['mail'];
    }

  
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Completa tu cotizacion. ')
            ->greeting('Hola ' . $this->usuario . '! ')
            ->line('Veo que te quedaste a la mitad de la cotizacion de tu importacion. ')
            ->line('Nuestro equipo de expertos esta listo para apoyarte en el proceso y aclarar cualquier duda que tengas.')
            ->action('Ingresar', url('/imporComex/public/login'))
            ->salutation('Conatacte con ellos ahora! ');
    }

   
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
