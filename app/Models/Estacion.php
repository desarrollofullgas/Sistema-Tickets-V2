<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Estacion extends Model
{
    use SoftDeletes;

    use HasFactory;
    protected $fillable = [
        'name', 'user_id', 'zona_id', 'supervisor_id', 'num_estacion'
    ];

    public function scopeSearch($query, $value)
    {
        $query->where(function ($query) use ($value) {
            $query->where('id', 'like', "%{$value}%")
                ->orWhere('name', 'like', "%{$value}%")
                ->orWhere('num_estacion', 'like', "%{$value}%")
                ->orWhere('status', 'like', "%{$value}%")
                ->orWhere('created_at', 'like', "%{$value}%");
        })->orWhere(function ($query) use ($value) {
            $query->whereIn('zona_id', function ($subquery) use ($value) {
                $subquery->select('id')
                    ->from('zonas')
                    ->where('name', 'LIKE', "%{$value}%");
            })->orWhereIn('user_id', function ($subquery) use ($value) {
                $subquery->select('id')
                    ->from('users')
                    ->where('name', 'LIKE', "%{$value}%");
            })->orWhereIn('supervisor_id', function ($subquery) use ($value) {
                $subquery->select('id')
                    ->from('users')
                    ->where('name', 'LIKE', "%{$value}%");
            });
        });
    }
    public function getStatusColorAttribute()
    {
        return [
            'Activo' => 'green',
            'Inactivo' => 'red',
        ][$this->status] ?? 'gray';
    }

    public function zona()
    {
        return $this->belongsTo(Zona::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }
}
