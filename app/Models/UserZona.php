<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserZona extends Model
{
    use HasFactory;

    protected $table = 'user_zona';

    public function zona()
    {
        return $this->belongsTo(Zona::class);
    }
}
