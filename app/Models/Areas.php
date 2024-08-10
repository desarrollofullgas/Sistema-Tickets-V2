<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Areas extends Model
{
    use HasFactory;
    use SoftDeletes;
	
	public function scopeSearch($query, $value){
        $query->where('id', 'like', "%{$value}%")
            ->orWhere('name', 'like', "%{$value}%")
            ->orWhere('status', 'like', "%{$value}%")
            ->orWhere('created_at', 'like', "%{$value}%")
            ->orWhereIn('departamento_id', function ($subquery) use ($value) {
                $subquery->select('id')
                    ->from('departamentos')
                    ->where('name', 'LIKE', "%{$value}%");
            });
    }
    public function getStatusColorAttribute(){
        return[
            'Activo' => 'green',
            'Inactivo' => 'red',
        ][$this->status] ?? 'gray';
    }

    public function servicios(): HasMany
    {
        return $this->hasMany(Servicio::class, 'area_id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_areas', 'area_id');
    }
    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }
}
