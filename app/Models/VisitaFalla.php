<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitaFalla extends Model
{
    use HasFactory;

    public function falla()
    {
        return $this->belongsTo(Falla::class);
    }
}
