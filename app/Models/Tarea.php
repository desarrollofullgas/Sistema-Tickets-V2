<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use RealRashid\SweetAlert\Facades\Alert;

class Tarea extends Model
{
    use HasFactory;
    use SoftDeletes;
	
	public function scopeSearch($query, $value)
{
    return $query->where(function ($query) use ($value) {
        $query->where('id', 'like', "%{$value}%")
            ->orWhere('asunto', 'like', "%{$value}%")
            ->orWhere('mensaje', 'like', "%{$value}%")
            ->orWhere('status', 'like', "%{$value}%")
            ->orWhere('created_at', 'like', "%{$value}%");
    })->orWhere(function ($query) use ($value) {
        $query->whereIn('ticket_id', function ($subquery) use ($value) {
            $subquery->select('id')
                ->from('tickets')
                ->where('id', 'LIKE', "%{$value}%");
        })->orWhere(function ($query) use ($value) {
            $query->whereIn('user_id', function ($subquery) use ($value) {
                $subquery->select('id')
                    ->from('users')
                    ->where('name', 'LIKE', "%{$value}%");
            })->orWhere(function ($query) use ($value) {
                $query->whereIn('user_asignado', function ($subquery) use ($value) {
                    $subquery->select('id')
                        ->from('users')
                        ->where('name', 'LIKE', "%{$value}%");
                });
            });
        });
    });
}
    public function getStatusColorAttribute()
    {
        return [
            'Abierto' => 'blue',
            'En Proceso' => 'green',
            'Cerrado' => 'indigo',
        ][$this->status] ?? 'gray';
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_asignado');
    }
    public function usercrea()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function compras()
{
    return $this->belongsToMany(Compra::class, 'tarea_compra', 'tarea_id', 'compra_id');
}
   

//    public static function boot()
//    {
//        parent::boot();

//        static::updating(function ($tarea) {
//            if ($tarea->isDirty('status')) {
//                if ($tarea->status === 'Cerrado') {
//                    $ticket = Ticket::find($tarea->ticket_id);
//                    $ticket->status = 'Cerrado';
//                    $tarea->save();

//                    Alert::success('Tarea Cerrada', 'La tarea y el ticket se han cerrado.');
//                } elseif ($tarea->status === 'En Proceso') {
//                    $ticket = Ticket::find($tarea->ticket_id);
//                    $ticket->status = 'En proceso';
//                    $ticket->save();

//                    Alert::success('Tarea En Proceso', 'La tarea y el ticket estan en proceso de solución.');
//                }
//            }
//        });
//    }
}
