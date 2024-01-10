<?php

namespace App\Notifications;

use App\Models\Visita;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifiNewVisita extends Notification
{
    use Queueable;
    public $visita;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Visita $visita)
    {
        $this->visita = $visita;
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
        
        return [
            'url' => route('visitas'),
            'userid' =>  $this->visita->solicita->toArray(),
            'user' => $this->visita->solicita->name,
            'message' => ", ha generado la visita #{$this->visita->id}, para la estación {$this->visita->estacion->name}"
        ];
    }


    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([ ]);
    }
}
