<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\URL;

class VerifyEmails extends Notification
{
    use Queueable;

    public static $createUrlCallback;
    public static $toMailCallback;

    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
        }

        return $this->buildMailMessage($verificationUrl);
    }

    protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->subject(Lang::get('Verificación De Email'))
            ->greeting('Hola que tal!')
            ->line(Lang::get('¡Gracias por registrarte en Imporcomex!.'))
            ->line(Lang::get('Verifica tu dirección de correo electrónico para mantener tu cuenta segura. En nuestro cotizador, podras calcular la logistica e impuestos de tus importaciones.'))
            ->action(Lang::get('Verificar Email'), $url)
            ->line(Lang::get('Gracias por usar nuestra aplicacion!.'))
            ->salutation(Lang::get('Saludos, Imporcomex'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    protected function verificationUrl($notifiable)
    {
        if (static::$createUrlCallback) {
            return call_user_func(static::$createUrlCallback, $notifiable);
        }

        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }

    public static function createUrlUsing($callback)
    {
        static::$createUrlCallback = $callback;
    }
    public static function toMailUsing($callback)
    {
        static::$toMailCallback = $callback;
    }
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
