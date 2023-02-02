<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use PhpParser\Node\Expr\Cast\String_;

class SendPassword extends Notification
{
    use Queueable;

    protected $password;
  

    public function __construct(String $password)
    {
        $this->password = $password;
        
    }


    public function via($notifiable)
    {
        return ['mail'];
    }


    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Usuario nuevo')
            ->greeting('¡Gracias por registrarte en Imporcomex!')
            ->line('Nuestros expertos te han registrado en el sistema y se te ha creado una contraseña  temporal .')
            ->action('Ingresar al sistema', url('/'))
            ->line('Tu contraseña temporal es: '.$this->password)
            ->salutation('Gracias por usar nuestra aplicacion!');
    }


    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
