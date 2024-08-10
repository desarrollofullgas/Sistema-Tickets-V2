<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Compra extends Model
{
    use HasFactory;
	use SoftDeletes;

    protected function tituloCorreo():Attribute{
        return Attribute::make(
            set:fn(string $value)=> strtoupper($value),
        );
    }
	
	public function scopeSearch($query, $value)
    {
        $query->where(function ($query) use ($value) {
            $query->where('id', 'like', "%{$value}%")
                ->orWhere('titulo_correo', 'like', "%{$value}%")
                ->orWhere('solucion', 'like', "%{$value}%")
                ->orWhere('problema', 'like', "%{$value}%")
                ->orWhere('com_rev', 'like', "%{$value}%")
                ->orWhere('mensaje_opcion', 'like', "%{$value}%")
                ->orWhere('status', 'like', "%{$value}%")
                ->orWhere('created_at', 'like', "%{$value}%");
        })->orWhere(function ($query) use ($value) {
            $query->whereIn('ticket_id', function ($subquery) use ($value) {
                $subquery->select('id')
                    ->from('tickets')
                    ->where('id', 'LIKE', "%{$value}%");
            })->orWhereHas('ticket', function ($subquery) use ($value) {
                $subquery->whereHas('agente', function ($userQuery) use ($value) {
                    $userQuery->where('name', 'LIKE', "%{$value}%");
                });
            })->orWhereHas('ticket', function ($subquery) use ($value) {
                $subquery->whereHas('cliente', function ($userQuery) use ($value) {
                    $userQuery->where('name', 'LIKE', "%{$value}%");
                });
            });
        });
    }
    public function getStatusColorAttribute()
    {
        return [
            'Solicitado' => 'blue',
            'Aprobado' => 'green',
            'Enviado a compras' => 'orange',
            'Completado' => 'indigo',
            'Rechazado' => 'red',
        ][$this->status] ?? 'gray';
    }

    public function ticket():BelongsTo{
        return $this->belongsTo(Ticket::class);
    }
   
    public function productos():HasMany{
        return $this->hasMany(CompraDetalle::class);
    }
    public function servicios():HasMany
    {
        return $this->hasMany(CompraServicio::class);
    }
    public function evidencias():HasMany{
        return $this->hasMany(ArchivosCompra::class);
    }
    public function comentarios():HasMany
    {
        return $this->hasMany(ComentariosCompra::class)->orderBy('id','DESC');
    }
    public function tareas()
{
    return $this->belongsToMany(Tarea::class, 'tarea_compra', 'compra_id', 'tarea_id');
}
}
