<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use RealRashid\SweetAlert\Facades\Alert;

class Tarea extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_asignado');
    }

//    public static function boot()
//    {
//        parent::boot();

//        static::updating(function ($tarea) {
//            if ($tarea->isDirty('status')) {
//                if ($tarea->status === 'Cerrado') {
//                    $ticket = Ticket::find($tarea->ticket_id);
//                    $ticket->status = 'Cerrado';
//                    $tarea->save();

//                    Alert::success('Tarea Cerrada', 'La tarea y el ticket se han cerrado.');
//                } elseif ($tarea->status === 'En Proceso') {
//                    $ticket = Ticket::find($tarea->ticket_id);
//                    $ticket->status = 'En proceso';
//                    $ticket->save();

//                    Alert::success('Tarea En Proceso', 'La tarea y el ticket estan en proceso de solución.');
//                }
//            }
//        });
//    }
}
