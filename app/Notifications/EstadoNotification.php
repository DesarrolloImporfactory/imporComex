<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EstadoNotification extends Notification
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
            ->subject('Que Sucedio ..??')
            ->greeting('Hola ' . $this->usuario . '! ')
            ->line('Hace unos dias te registraste en nuestra Plataforma de importaciones')
            ->line('recuerda que aqui podras Cotizar tus cargas e impuestos de manera eficas y optimizada,  Revisa las tarifas de nuestras importaciones grupales.')
            ->action('Te invitamos al sistema', url('/imporComex/public/login'))
            ->error(' (Las Mejores del mercado) ')
            ->salutation('Te esperamos!');
    }

   
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
