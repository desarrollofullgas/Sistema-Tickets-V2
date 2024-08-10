<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meals extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'start_time',
        'end_time',
    ];

}
