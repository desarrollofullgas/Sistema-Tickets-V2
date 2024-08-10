<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use SoftDeletes;
    use HasFactory;
	
	//mutador para el campo name (pasamos a mayusculas)
    protected function name():Attribute{
        return Attribute::make(
            set:fn(string $value)=> mb_strtoupper($value),
        );
    }
	
	public function scopeSearch($query, $value)
    {
        $query->where('id', 'like', "%{$value}%")
            ->orWhere('name', 'like', "%{$value}%")
            ->orWhere('descripcion', 'LIKE', '%' . $value . '%')
            ->orWhere('unidad', 'LIKE', '%' . $value . '%')
            ->orWhere('modelo', 'LIKE', '%' . $value . '%')
            ->orWhere('status', 'like', "%{$value}%")
            ->orWhere('created_at', 'like', "%{$value}%")
            ->orWhereIn('categoria_id', function ($subquery) use ($value) {
                $subquery->select('id')
                    ->from('categorias')
                    ->where('name', 'LIKE', "%{$value}%");
            })->orWhereIn('marca_id', function ($subquery) use ($value) {
                $subquery->select('id')
                    ->from('marcas')
                    ->where('name', 'LIKE', "%{$value}%");
            });
    }
    public function getStatusColorAttribute()
    {
        return [
            'Activo' => 'green',
            'Inactivo' => 'red',
        ][$this->status] ?? 'gray';
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
    public function marca():BelongsTo{
        return $this->belongsTo(Marca::class);
    }
    public function compras():HasMany
    {
        return $this->hasMany(CompraDetalle::class,'producto_id');
    }
}
