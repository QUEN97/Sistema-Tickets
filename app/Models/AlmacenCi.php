<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlmacenCi extends Model
{
    use HasFactory;

    public function producto():BelongsTo
    {
        return $this->belongsTo(Producto::class,'producto_id');
    }

   
}
