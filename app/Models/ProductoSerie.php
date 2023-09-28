<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoSerie extends Model
{
    use HasFactory;

    protected $table = 'producto_series';

    protected $fillable = [
        'serie',
        'producto_id',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
    
}
