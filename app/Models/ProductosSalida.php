<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductosSalida extends Model
{
    use HasFactory;

    public function producto():BelongsTo
    {
        return $this->belongsTo(Producto::class,'producto_id');
    }
    public function estacion():BelongsTo
    {
        return $this->belongsTo(Estacion::class);
    }
    public function ticket():BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }
    public function serie():HasOne
    {
        return $this->hasOne(ProductoSerieSalida::class,'producto_salida_id');
    }
}
