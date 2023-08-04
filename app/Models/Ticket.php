<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use RealRashid\SweetAlert\Facades\Alert;

class Ticket extends Model
{
    use HasFactory;

    public function falla(): BelongsTo
    {
        return $this->belongsTo(Falla::class);
    }
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'solicitante_id');
    }
    public function agente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function archivos(): HasMany
    {
        return $this->hasMany(ArchivosTicket::class);
    }
    public function tareas()
    {
        return $this->hasMany(Tarea::class, 'ticket_id');
    }
    public function compras():HasMany{
        return $this->hasMany(Compra::class, 'ticket_id');
    }
    public function comentarios():HasMany{
        return $this->hasMany(Comentario::class)->orderBy('id', 'DESC');
    }

}
