<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use RealRashid\SweetAlert\Facades\Alert;

class Ticket extends Model
{
    use HasFactory;

        //mutador para el campo asunto (pasamos a mayusculas)
        protected function asunto():Attribute{
            return Attribute::make(
                set:fn(string $value)=> mb_strtoupper($value),
            );
        }

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
    public function reqs():HasMany{
        return $this->hasMany(Compra::class);
    }
    public function comentarios():HasMany{
        return $this->hasMany(Comentario::class)->orderBy('id', 'DESC');
    }

}
