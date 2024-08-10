<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductosEntrada extends Model
{
    use HasFactory;

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
    public function estacion(): BelongsTo
    {
        return $this->belongsTo(Estacion::class);
    }
     public function serie():HasOne
    {
        return $this->hasOne(ProductoSerieEntrada::class,'producto_entrada_id');
    }
    public function serie2():HasOne
    {
        return $this->hasOne(ProductoSerieEntrada::class,'producto_entrada_id')->where('ha_salido', 0);
    }
	public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }
}
