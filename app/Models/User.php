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
		'telefono',
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

	public function scopeSearch($query, $value)
    {
        $query->where(function ($query) use ($value) {
            $query->where('id', 'like', "%{$value}%")
                ->orWhere('name', 'like', "%{$value}%")
                ->orWhere('username', 'like', "%{$value}%")
                ->orWhere('email', 'like', "%{$value}%")
                ->orWhere('status', 'like', "%{$value}%")
                ->orWhere('created_at', 'like', "%{$value}%");
        })->orWhere(function ($query) use ($value) {
            $query->whereIn('permiso_id', function ($subquery) use ($value) {
                $subquery->select('id')
                    ->from('permisos')
                    ->where('titulo_permiso', 'LIKE', "%{$value}%");
            });
        })->orWhereHas('zonas', function ($query) use ($value) {
            $query->where('name', 'like', "%{$value}%");
        })
            ->orWhereHas('areas', function ($query) use ($value) {
                $query->where('name', 'like', "%{$value}%");
            });
    }
    public function getStatusColorAttribute()
    {
        return [
            'Activo' => 'green',
            'Inactivo' => 'red',
        ][$this->status] ?? 'gray';
    }
   
    

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
    public function tckGen():HasMany
    {
        return $this->hasMany(Ticket::class,'solicitante_id');
    }
    public function ticketsHoy(){  //asignamos tickets de manera equitativa, sin que se reinicie cada dia
        $fechaHoy=Carbon::now();
        $hoy=$fechaHoy->format('Y-m-d');
        $ayer=$fechaHoy->subDay()->format('Y-m-d');
        return $this->hasMany(Ticket::class)->whereBetween('created_at',[$ayer.' 00:00:00',$hoy.' 23:59:00']);
    }
    public function tareasHoy(){  //asignamos tareas de manera equitativa, sin que se reinicie cada dia
        $fechaHoy=Carbon::now();
        $hoy=$fechaHoy->format('Y-m-d');
        $ayer=$fechaHoy->subDay()->format('Y-m-d');
        return $this->hasMany(Tarea::class)->whereBetween('created_at',[$ayer.' 00:00:00',$hoy.' 23:59:00']);
    }

    public function salidas():HasMany
    {
        return $this->hasMany(Salida::class)->orderBy('id','DESC');
    }
    public function entradas():HasMany
    {
        return $this->hasMany(Entrada::class)->orderBy('id','DESC');
    }
	public function visitas()
    {
        return $this->belongsToMany(Visita::class, 'user_visitas')
                    ->withPivot('llegada', 'retirada');
    }
	public function tareas():HasMany
    {
        return $this->hasMany(Tarea::class,'user_asignado');
    }
	public function likes(){
        return $this->hasMany(Like::class);
    }
}