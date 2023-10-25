<?php

namespace App\Notifications;

use App\Models\Compra;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class NewCompraServicioNotification extends Notification
{
    use Queueable;
    public $compra;

    /**
     * Create a new notification instance.
     */
    public function __construct(Compra $compra)
    {
        $this->compra = $compra;
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
            'url' => route('requisiciones'),
            'photo' => $photo,
            'user' => Auth::user()->name,
            'message' => ", ha creado una requisición de Servicios #{$this->compra->id}, 
            en el ticket #{$this->compra->ticket_id}, '{$this->compra->titulo_correo}' "  
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
        ]);
    }
}
