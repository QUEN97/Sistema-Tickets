<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class FoliosSalida extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function salidas():HasMany
    {
        return $this->hasMany(Salida::class,'folio_id')->orderBy('id','DESC');
    }
    public function usersCount():HasMany
    {
        return $this->hasMany(Salida::class,'folio_id')->select('user_id')->groupBy('user_id');
    }
}
