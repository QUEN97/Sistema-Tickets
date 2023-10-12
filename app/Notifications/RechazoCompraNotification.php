<?php

namespace App\Notifications;

use App\Models\Compra;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class RechazoCompraNotification extends Notification
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
        return [
            'url' => route('requisiciones'),
            'message' => "El usuario " .  Auth::user()->name . " " . "no autorizó la requisición #{$this->compra->id}, 
            en el ticket #{$this->compra->ticket_id}."  
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
        ]);
    }
}