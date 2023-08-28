<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FoliosEntrada extends Model
{
    use HasFactory;
    use HasFactory;
    public function entradas():HasMany
    {
        return  $this->hasMany(Entrada::class,'folio_id')->orderBy('id','DESC');
    }
    public function usersCount():HasMany
    {
        return $this->hasMany(Entrada::class,'folio_id')->select('user_id')->groupBy('user_id');
    }
}
