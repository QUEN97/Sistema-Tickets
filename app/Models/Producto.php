<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Producto extends Model
{
    use SoftDeletes;
    use HasFactory;

    //mutador para el campo name (pasamos a mayusculas)
    protected function name():Attribute{
        return Attribute::make(
            set:fn(string $value)=> mb_strtoupper($value),
        );
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
    public function marca():BelongsTo{
        return $this->belongsTo(Marca::class);
    }
    public function compras():HasMany
    {
        return $this->hasMany(CompraDetalle::class,'producto_id');
    }
}
