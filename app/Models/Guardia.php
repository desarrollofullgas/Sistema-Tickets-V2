<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Guardia extends Model
{
    use HasFactory;
    
    protected $fillable=['id','user_id','status','orden'];
    public function usuario():BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
