<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealUsers extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'meal_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function meal()
    {
        return $this->belongsTo(Meals::class, 'meal_id');
    }
}
