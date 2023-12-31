<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Falla extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => mb_strtoupper($value),
        );
    }

    public function servicio(): BelongsTo
    {
        return $this->belongsTo(Servicio::class);
    }
    public function prioridad(): BelongsTo
    {
        return $this->belongsTo(Prioridad::class);
    }
    public function tickets(array $dates):HasMany
    {
        return $this->hasMany(Ticket::class)->whereBetween('created_at', $dates);
    }
    public function alltickets():HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
