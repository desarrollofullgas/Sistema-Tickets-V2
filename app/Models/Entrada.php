<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Entrada extends Model
{
    use HasFactory; public function folio():BelongsTo
    {
        return $this->belongsTo(FoliosEntrada::class);
    }
    public function usuario():BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function productos():HasMany
    {
        return $this->hasMany(ProductosEntrada::class);
    }
}
