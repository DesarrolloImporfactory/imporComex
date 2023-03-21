<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OnBoarding extends Notification
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
            ->subject('inducción! ')
            ->greeting('Hola ' . $this->usuario . ', que gusto tener aqui. ')
            ->line(' Me presento por si no me conocez, mi nombre es Daniel Bonilla, IMPORTADOR de vocacion, y antes de presentarte, nuestra plataforma, dejame decirte una sola cosa, Vamos a revolucionar el mundo de las importaciones, con una manera Facil, pero principalmente optimizada de realizar tus procesos de importacion. . ')
            ->action('Ver', url('/imporComex/public/login'))
            ->line('Asi que mira este video, para que conozcas Nuestra herramienta echa de importadores, para importadores .')
            ->salutation('Un gusto tenerte aqui! ');
    }


    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
