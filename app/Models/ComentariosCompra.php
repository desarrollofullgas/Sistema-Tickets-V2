<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class ComentariosCompra extends Model
{
    use HasFactory;

    public function usuario():BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
