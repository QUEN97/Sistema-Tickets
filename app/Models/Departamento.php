<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departamento extends Model
{
    use HasFactory;
    use SoftDeletes;

    //funcion para devolver la lista de areas que tenga el departamento (uno a muchos normal)
    public function areas(): HasMany {
        return $this->hasMany(Areas::class)->orderBy('name', 'ASC');
    }

}
