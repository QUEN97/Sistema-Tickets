<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Notifications extends Component
{


   public function getListeners(){
       return [
           'echo-notification:App.Models.User.' . auth()->id() . ',TicketAsignadoNotificacion' => 'render',
       ];
   }

 
    public function readNotification($id)
    {
        auth()->user()->notifications->find($id)->markAsRead();
    }
    public function readAllNotification()
    {
        auth()->user()->unreadNotifications->markAsRead();
    }
    public function render()
    {
        return view('livewire.notifications');
    }
}
