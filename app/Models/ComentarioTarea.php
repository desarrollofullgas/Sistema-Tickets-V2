<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComentarioTarea extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function usuario():BelongsTo{
        return $this->belongsTo(User::class,'user_id');
    }

    public function tarea():BelongsTo{
        return $this->belongsTo(Tarea::class);
    }
}
