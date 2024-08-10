<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlmacenCi extends Model
{
    use HasFactory;
	
	 public function scopeSearch($query, $value){
        $query->where('id', 'like', "%{$value}%")
            ->orWhere('stock', 'like', "%{$value}%")
            ->orWhere('stock_base', 'like', "%{$value}%")
            ->orWhere('created_at', 'like', "%{$value}%")
            ->orWhereIn('producto_id', function ($subquery) use ($value) {
                $subquery->select('id')
                    ->from('productos')
                    ->where('name', 'LIKE', "%{$value}%");
            });
    }

    public function producto():BelongsTo
    {
        return $this->belongsTo(Producto::class,'producto_id');
    }

   
}
