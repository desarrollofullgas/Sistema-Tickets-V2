<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZonaRegion extends Model
{
    use HasFactory;

    protected $fillable = ['zona_regions'];

    public function regions()
    {
        return $this->hasMany(Region::class);
    }
}
