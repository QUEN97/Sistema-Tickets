<?php

namespace App\Notifications;

use App\Models\Tarea;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class TareaReasignada extends Notification
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

        //$newAssignedUserName = $notifiable->name;
        return [
            'url' => route('tareas'),
            'photo' => $photo,
            'user' => "El " .  Auth::user()->permiso->titulo_permiso . " " . Auth::user()->name,
            'message' => " te ha reasignado la tarea #{$this->tarea->id}, en el ticket #{$this->tarea->ticket_id}."
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
        ]);
    }
}
