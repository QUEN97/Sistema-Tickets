<?php

namespace App\Http\Livewire\Tickets;

use App\Models\Comentario;
use App\Models\Like;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\DisLikeNotification;
use App\Notifications\LikeNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LikeDislike extends Component
{
    public $comentario;

    public function mount(Comentario $comentario)
    {
        $this->comentario = $comentario;
    }

    public function toggleLike($type)
    {
    // Validate the type
    if (!in_array($type, ['like', 'dislike'])) {
        return;
    }

    $existingLike = Like::where('comentario_id', $this->comentario->id)
        ->where('user_id', Auth::id())
        ->first();

    $typeString = $type; // Simplificamos el tipo a asignar

    $admins = User::where('permiso_id', 1)->where('status','Activo')->get();

    if ($existingLike) {
        if ($existingLike->type === $typeString) {
            $existingLike->delete(); // eliminamos la reaccion like/dislike
        } else {
            $existingLike->type = $typeString; // actualizamos la reaccion like/dislike
            $existingLike->save();
            
            if ($typeString === 'dislike') {
                Notification::send($admins, new DisLikeNotification($existingLike));// Enviar notificación de dislike
            } else {
                Notification::send($admins, new LikeNotification($existingLike)); 
            }
        }
    } else {
        $newLike = new Like();
        $newLike->comentario_id = $this->comentario->id;
        $newLike->user_id = Auth::id();
        $newLike->type = $typeString; // establecemos la nueva reaccion
        $newLike->save();
        
        if ($typeString === 'like') {
            Notification::send($admins, new LikeNotification($newLike)); // Enviar notificación de like
        } else {
           Notification::send($admins, new DisLikeNotification($newLike)); 
        }
    }

    $this->comentario->load('likes'); // recargamos la relacion
}


    public function render()
    {
        return view('livewire.tickets.like-dislike');
    }
}
