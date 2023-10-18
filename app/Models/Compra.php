<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Compra extends Model
{
    use HasFactory;

    protected function tituloCorreo():Attribute{
        return Attribute::make(
            set:fn(string $value)=> strtoupper($value),
        );
    }

    public function ticket():BelongsTo{
        return $this->belongsTo(Ticket::class);
    }
   
    public function productos():HasMany{
        return $this->hasMany(CompraDetalle::class);
    }
    public function servicios():HasMany
    {
        return $this->hasMany(CompraServicio::class);
    }
    public function evidencias():HasMany{
        return $this->hasMany(ArchivosCompra::class);
    }
    public function comentarios():HasMany
    {
        return $this->hasMany(ComentariosCompra::class)->orderBy('id','DESC');
    }
}
