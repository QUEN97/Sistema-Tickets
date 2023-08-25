<?php

namespace App\Notifications;

use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Notification;

class TicketAgenteComentarioNotification extends Notification implements ShouldBroadcast
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
    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'tckId' => $this->ticket->id,
            'asignado' => $this->ticket->agente->name,
            'cliente' => $this->ticket->cliente->name,
            'status' => $this->ticket->status,
            'fecha' => $this->ticket->created_at->format('d/m/Y H:i:s A'),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'ticket_id' => $this->ticket->id,
            'message' => '¡Se te ha asignado un nuevo ticket!'
        ]);
    }
}
