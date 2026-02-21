<?php

namespace App\Notifications;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistrationConfirmed extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Event $event)
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Registration Confirmed - ' . $this->event->title)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('You have successfully registered for: ' . $this->event->title)
            ->line('Event Details:')
            ->line('Date: ' . $this->event->start_time->format('F j, Y'))
            ->line('Time: ' . $this->event->start_time->format('g:i A'))
            ->line('Location: ' . $this->event->location)
            ->action('View Event', url('/events/' . $this->event->id))
            ->line('We look forward to seeing you there!');
    }
}
