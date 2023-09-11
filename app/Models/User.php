<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'permiso_id',
        'region_id',
        'estacion_id',
        'email',
        'password',
        'last_seen',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

   
    

    public function permiso()
    {
        return $this->belongsTo(Permiso::class);
    }

    public function zonas()
    {
        return $this->belongsToMany(Zona::class, 'user_zona');
    }

    public function estacion()
    {
        return $this->hasOne(Estacion::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function tarea()
    {
        return $this->belongsTo(Tarea::class);
    }

    public function areas(){
        return $this->belongsToMany(Areas::class,'user_areas',null,'area_id');
    }

    public function region(){
        return $this->belongsTo(Region::class);
    }

    public function tickets():HasMany{
        return $this->hasMany(Ticket::class);
    }
    public function ticketsHoy(){  //asignamos tickets de manera equitativa, sin que se reinicie cada dia
        $fechaHoy=Carbon::now();
        $hoy=$fechaHoy->format('Y-m-d');
        $ayer=$fechaHoy->subDay()->format('Y-m-d');
        return $this->hasMany(Ticket::class)->whereBetween('created_at',[$ayer.' 00:00:00',$hoy.' 23:59:00']);
    }

    public function salidas():HasMany
    {
        return $this->hasMany(Salida::class)->orderBy('id','DESC');
    }
    public function entradas():HasMany
    {
        return $this->hasMany(Entrada::class)->orderBy('id','DESC');
    }

}