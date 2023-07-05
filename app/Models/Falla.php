<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Falla extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    public function servicio():BelongsTo{
        return $this->belongsTo(Servicio::class);
    }
    public function prioridad():BelongsTo{
        return $this->belongsTo(Prioridad::class);
    }
}
