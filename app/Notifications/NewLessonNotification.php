<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewLessonNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $lesson;

    public function __construct($lesson)
    {
        $this->lesson = $lesson;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nouvelle leçon disponible : ' . $this->lesson->title)
            ->greeting('Salut ' . $notifiable->name . ' 👋')
            ->line('Une nouvelle leçon vient d’être ajoutée au cours.')
            ->line('📖 ' . $this->lesson->title)
            ->action('Voir la leçon', url('/lessons/' . $this->lesson->id))
            ->line('Bonne continuation 🚀');
    }
}
