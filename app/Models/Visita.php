<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Visita extends Model
{
    use HasFactory;

    protected $fillable = ['estacion_id','motivo_visita','fecha_programada','solicita_id'];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function solicita(): BelongsTo
    {
        return $this->belongsTo(User::class, 'solicita_id');
    }
    public function estacion(): BelongsTo
    {
        return $this->belongsTo(Estacion::class);
    }
}
