<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TestNotification extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Mail de test en local')
                    ->line('Ceci est un test d’email via Mailpit 🚀')
                    ->action('Visiter mon app', url('/'))
                    ->line('Merci d’utiliser Laravel !');
    }
}
