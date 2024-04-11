<?php

namespace App\Notifications;

use App\Models\Comentario;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class DisLikeNotification extends Notification
{
    use Queueable;
    public $com;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Comentario $com)
    {
        $this->com = $com;
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
            'url' => route('tck.ver', $this->com->tickets->id),
            'userid' =>  Auth::user()->name,
            'user' => Auth::user()->name,
            'message' => ", ha reaccionado "
        ];
    }


    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([ ]);
    }
}
