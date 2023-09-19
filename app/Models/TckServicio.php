<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class TckServicio extends Model
{
    use HasFactory;
    protected function name():Attribute
    {
        return Attribute::make(
            set:fn(string $value)=> mb_strtoupper($value),
        );
    }
    public function compras():HasMany
    {
        return $this->hasMany(CompraServicio::class,'servicio_id');
    }
}
