<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CorreosZona extends Model
{
    use HasFactory;
	
	 public function scopeSearch($query, $value)
    {
        $query->where(function ($query) use ($value) {
            $query->where('created_at', 'like', "%{$value}%");
        })->orWhere(function ($query) use ($value) {
            $query->whereIn('categoria_id', function ($subquery) use ($value) {
                $subquery->select('id')
                    ->from('categorias')
                    ->where('name', 'LIKE', "%{$value}%");
            })->orWhereIn('zona_id', function ($subquery) use ($value) {
                $subquery->select('id')
                    ->from('zonas')
                    ->where('name', 'LIKE', "%{$value}%");
            })->orWhereIn('correo_id', function ($subquery) use ($value) {
                $subquery->select('id')
                    ->from('correos_compras')
                    ->where('correo', 'LIKE', "%{$value}%");
            });
        });
    }
	
    public function correo():BelongsTo
    {
        return $this->belongsTo(CorreosCompra::class);
    }
    public function categoria():BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }
    public function zona():BelongsTo
    {
        return $this->belongsTo(Zona::class);
    }
}
