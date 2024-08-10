<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servicio extends Model
{
    use HasFactory;
    use SoftDeletes;
	
	 public function scopeSearch($query, $value){
        $query->where('id', 'like', "%{$value}%")
            ->orWhere('name', 'like', "%{$value}%")
            ->orWhere('status', 'like', "%{$value}%")
            ->orWhere('created_at', 'like', "%{$value}%")
            ->orWhereIn('area_id', function ($subquery) use ($value) {
                $subquery->select('id')
                    ->from('areas')
                    ->where('name', 'LIKE', "%{$value}%");
            });
    }
    public function getStatusColorAttribute(){
        return[
            'Activo' => 'green',
            'Inactivo' => 'red',
        ][$this->status] ?? 'gray';
    }

    public function prioridad():BelongsTo{
        return $this->belongsTo(Prioridad::class);
    }
    public function area():BelongsTo{
        return $this->belongsTo(Areas::class);
    }
    public function fallas():HasMany{
        return $this->hasMany(Falla::class);
    }
}
