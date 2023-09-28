<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductosEntrada extends Model
{
    use HasFactory;

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
    public function estacion(): BelongsTo
    {
        return $this->belongsTo(Estacion::class);
    }
    public function serie()
    {
        return $this->belongsTo(ProductoSerie::class, 'id');
    }
}
