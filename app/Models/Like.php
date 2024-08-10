<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    use HasFactory;

    protected $table = 'like_dislike';
    protected $fillable = ['comentario_id','user_id','type'];

    public function comentario(): BelongsTo
    {
        return $this->belongsTo(Comentario::class);
    }
    
}
