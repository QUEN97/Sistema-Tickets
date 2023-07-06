<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use SoftDeletes;
    use HasFactory;

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
    public function marca():BelongsTo{
        return $this->belongsTo(Marca::class);
    }
}
