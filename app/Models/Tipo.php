<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tipo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected function name():Attribute
    {
        return Attribute::make(
            set:fn(string $value)=> mb_strtoupper($value),
        );
    }

    public function prioridad() :HasMany{
        return $this->hasMany(Prioridad::class);
    }
}
