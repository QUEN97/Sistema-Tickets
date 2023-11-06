<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminNotify extends Notification
{
    use Queueable;
    public $ticket;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase(object $notifiable): array
    {
        $photo = isset($this->ticket->cliente->profile_photo_path) && !empty($this->ticket->cliente->profile_photo_path)
        ? $this->ticket->cliente->profile_photo_path
        : $this->ticket->cliente->profile_photo_url;
        return [
            'url' => route('tickets', $this->ticket->id),
            'photo' => $photo,
            'user' => $this->ticket->cliente->name,
            'message' => ", ha generado el ticket #{$this->ticket->id}, '{$this->ticket->falla->name}', y se le ha asignado a {$this->ticket->agente->name}"
        ];
    }


    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([ ]);
    }
}