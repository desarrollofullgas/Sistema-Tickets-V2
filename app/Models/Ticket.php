<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use RealRashid\SweetAlert\Facades\Alert;

class Ticket extends Model
{
    use HasFactory;

        //mutador para el campo asunto (pasamos a mayusculas)
        protected function asunto():Attribute{
            return Attribute::make(
                set:fn(string $value)=> mb_strtoupper($value),
            );
        }
	
	         public function scopeSearch($query, $value)
    {
        $query->where(function ($query) use ($value) {
            $query->where('tickets.id', 'like', "%{$value}%")
                ->orWhere('mensaje', 'like', "%{$value}%")
                ->orWhere('tickets.status', 'like', "%{$value}%")
                ->orWhere('tickets.created_at', 'like', "%{$value}%");
        })->orWhere(function ($query) use ($value) {
            $query->whereIn('falla_id', function ($subquery) use ($value) {
                $subquery->select('id')
                    ->from('fallas')
                    ->where('name', 'LIKE', "%{$value}%");
            })->orWhereIn('user_id', function ($subquery) use ($value) {
                $subquery->select('id')
                    ->from('users')
                    ->where('name', 'LIKE', "%{$value}%");
            })->orWhereIn('solicitante_id', function ($subquery) use ($value) {
                $subquery->select('id')
                    ->from('users')
                    ->where('name', 'LIKE', "%{$value}%");
            })
            ->orWhereHas('falla', function ($subquery) use ($value) {
                $subquery->whereHas('prioridad', function ($userQuery) use ($value) {
                    $userQuery->where('name', 'LIKE', "%{$value}%");
                });
            })
            ->orWhereHas('agente', function ($subquery) use ($value) {
                $subquery->whereHas('areas', function ($userQuery) use ($value) {
                    $userQuery->where('name', 'LIKE', "%{$value}%");
                });
            });
        })
        ->orWhereHas('cliente',function($cliente) use ($value) {
            $cliente->whereHas('zonas',function($zonas)use($value){
                $zonas->where('name','LIKE',"%{$value}%");
            });
        });
    }
    public function getStatusColorAttribute()
    {
        return [
            'Abierto' => 'green',
            'En proceso' => 'yellow',
            'Cerrado' => 'gray',
        ][$this->status] ?? 'gray';
    }

    public function falla(): BelongsTo
    {
        return $this->belongsTo(Falla::class);
    }
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'solicitante_id');
    }
    public function agente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function archivos(): HasMany
    {
        return $this->hasMany(ArchivosTicket::class);
    }
    public function tareas()
    {
        return $this->hasMany(Tarea::class, 'ticket_id');
    }
    public function compras():HasMany{
        return $this->hasMany(Compra::class, 'ticket_id');
    }
    public function comentarios():HasMany{
        return $this->hasMany(Comentario::class)->orderBy('id', 'DESC');
    }

}
