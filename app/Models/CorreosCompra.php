<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CorreosCompra extends Model
{
    use HasFactory;
    public function correosZona():HasMany
    {
        return $this->hasMany(CorreosZona::class);
    }
}
