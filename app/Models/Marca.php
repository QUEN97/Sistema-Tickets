<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Marca extends Model
{
    use HasFactory;
    use SoftDeletes;

    //mutador para el campo name (pasamos a mayusculas)
    protected function name():Attribute{
        return Attribute::make(
            set:fn(string $value)=> mb_strtoupper($value),
        );
    }

    public function scopeSearch($query, $value){
        $query->where('id', 'like', "%{$value}%")
            ->orWhere('name', 'like', "%{$value}%")
            ->orWhere('status', 'like', "%{$value}%")
            ->orWhere('created_at', 'like', "%{$value}%");
    }
    public function getStatusColorAttribute(){
        return[
            'Activo' => 'green',
            'Inactivo' => 'red',
        ][$this->status] ?? 'gray';
    }

    public function productos():HasMany{
        return $this->hasMany(Producto::class);
    }
}
