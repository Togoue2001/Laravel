<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCourseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $course;

    public function __construct($course)
    {
        $this->course = $course;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nouveau cours disponible : ' . $this->course->title)
            ->greeting('Bonjour ' . $notifiable->name . ' 👋')
            ->line('Un nouveau cours vient d’être ajouté sur la plateforme.')
            ->line('📘 ' . $this->course->title)
            ->action('Voir le cours', url('/courses/' . $this->course->id))
            ->line('Bonne formation 🚀');
    }
}
