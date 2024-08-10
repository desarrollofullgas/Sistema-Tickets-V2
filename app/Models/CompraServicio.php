<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompraServicio extends Model
{
    use HasFactory;
    public function servicio():BelongsTo
    {
        return $this->belongsTo(TckServicio::class,'servicio_id');
    }
}
