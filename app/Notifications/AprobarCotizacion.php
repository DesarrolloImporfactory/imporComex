<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AprobarCotizacion extends Notification
{
    use Queueable, SerializesModels;

    protected $pdfPath;


    public function __construct($pdfPath)
    {
        $this->pdfPath = $pdfPath;
    }


    public function via($notifiable)
    {
        return ['mail'];
    }


    public function toMail($notifiable)
    {
        $pdfContent = File::get($this->pdfPath);

        return (new MailMessage)
            ->subject('Aprobación de la cotización.')
            ->greeting('Hola, gracias por realizar tu cotización! ')
            ->line('Tu cotizacion ha generado un archivo en PDF con los detalles de todo el proceso y costos.')
            ->attachData($pdfContent, 'documento.pdf', [
                'mime' => 'application/pdf',
            ])
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
