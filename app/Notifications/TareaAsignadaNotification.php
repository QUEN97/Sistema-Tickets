<?php

namespace App\Notifications;

use App\Models\Tarea;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class TareaAsignadaNotification extends Notification
{
    use Queueable;
    public $tarea;

    /**
     * Create a new notification instance.
     */
    public function __construct(Tarea $tarea)
    {
        $this->tarea = $tarea;
    }
/**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }
    /**
     * Get the mail representation of the notification.
     */
    public function toDatabase($notifiable)
    {
        return [
            'tareaId' => $this->tarea->id,
            'tckId' => $this->tarea->ticket_id,
            'userEs' => Auth::user()->name,
            'asignado' => $this->tarea->user->name,
            'fecha' => $this->tarea->created_at->format('d/m/Y H:i:s A'),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'tarea_id' => $this->tarea->id,
            'message' => '¡Se te ha asignado un nuevo tarea!'
        ]);
    }
}
