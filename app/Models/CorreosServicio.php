<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CorreosServicio extends Model
{
    use HasFactory;

    public function correo():BelongsTo
    {
        return $this->belongsTo(CorreosCompra::class);
    }
    public function zona():BelongsTo
    {
        return $this->belongsTo(Zona::class);
    }
}
