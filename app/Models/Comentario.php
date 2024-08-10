<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comentario extends Model
{
    use HasFactory;
    use SoftDeletes;
    public function usuario():BelongsTo{
        return $this->belongsTo(User::class,'user_id');
    }
    public function archivos():HasMany {
        return $this->hasMany(ArchivosComentario::class);
    }
    public function tickets():HasMany{
        return $this->hasMany(Comentario::class,'ticket_id');
    }
	public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
	 public function likes(): HasMany
    {
        return $this->hasMany(Like::class, 'comentario_id');
    }

    public function isLikeByLoggedInUser()
    {
        return $this->likes->where('user_id', auth()->user()->id)->where('type', 'like')->isNotEmpty();
    }

    public function isDislikeByLoggedInUser()
    {
        return $this->likes->where('user_id', auth()->user()->id)->where('type', 'dislike')->isNotEmpty();
    }
}
