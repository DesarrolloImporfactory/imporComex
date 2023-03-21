<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WeekUser extends Notification
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
            ->subject('Esta herramienta no solo hace importaciones grupales. ')
            ->greeting('Hola ' . $this->usuario . '! ')
            ->line(' Me presento por si no me conocez, mi nombre es Daniel Bonilla, IMPORTADOR de vocacion, y antes de presentarte, nuestra plataforma, dejame decirte una sola cosa, Vamos a revolucionar el mundo de las importaciones, con una manera Facil, pero principalmente optimizada de realizar tus procesos de importacion. . ')
            ->action('Ver', url('/imporComex/public/login'))
            ->line('Asi que mira este video, para que conozcas Nuestra herramienta echa de importadores, para importadores .')
            ->salutation('Un gusto tenerte aqui! ');
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
