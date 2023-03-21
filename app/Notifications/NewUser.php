<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUser extends Notification
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
            ->subject('Aqui te dejo un ejemplo de una importacion. ')
            ->greeting('Hola ' . $this->usuario . '! ')
            ->line('Las importaciones grupales abrieron una oportunidad increible para los emprendedores y empresarios. ')
            ->line('Puedes llegar ahorrar hasta un 50% en logistica e incrementar de manera increible tu utilidad.')
            ->action('Ver', url('/imporComex/public/login'))
            ->line('Mira el ejemplo real utilizando nuestro cotizador.')
            ->salutation('Empieza ahora! ');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
