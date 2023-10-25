<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class TicketComentarioNotification extends Notification
{
    use Queueable;
    public $ticket;

    /**
     * Create a new notification instance.
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }
/**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }
    /**
     * Get the mail representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        $photo = isset(Auth::user()->profile_photo_path) && !empty(Auth::user()->profile_photo_path)
        ? Auth::user()->profile_photo_path
        : Auth::user()->profile_photo_url;
        return [
            'url' => route('tck.ver', $this->ticket->id),
            'photo' => $photo,
            'user' => "El " .  Auth::user()->permiso->titulo_permiso . " " . Auth::user()->name,
            'message' => " ha realizado un comentario en el ticket #{$this->ticket->id}."
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([ ]);
    }
}
