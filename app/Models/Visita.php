<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Visita extends Model
{
    use HasFactory;

    protected $fillable = ['estacion_id','motivo_visita','fecha_programada','solicita_id'];

    public function usuario(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'user_visitas');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_visitas')
                    ->withPivot('llegada', 'retirada');
    }
    public function solicita(): BelongsTo
    {
        return $this->belongsTo(User::class, 'solicita_id');
    }
    public function estacion(): BelongsTo
    {
        return $this->belongsTo(Estacion::class);
    }
    public function estavisita(): BelongsToMany
    {
        return $this->belongsToMany(Estacion::class,'visitas','estacion_id');
    }
    public function fallas(){
        return $this->belongsToMany(Falla::class,'visita_fallas',null,'falla_id');
    }
}
