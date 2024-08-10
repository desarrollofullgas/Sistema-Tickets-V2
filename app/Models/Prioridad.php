<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prioridad extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table="prioridades";
	
	public function scopeSearch($query, $value){
        $query->where('id', 'like', "%{$value}%")
            ->orWhere('name', 'like', "%{$value}%")
            ->orWhere('tiempo', 'like', "%{$value}%")
            ->orWhere('status', 'like', "%{$value}%")
            ->orWhere('created_at', 'like', "%{$value}%")
            ->orWhereIn('tipo_id', function ($subquery) use ($value) {
                $subquery->select('id')
                    ->from('tipos')
                    ->where('name', 'LIKE', "%{$value}%");
            });
    }
    public function getStatusColorAttribute(){
        return[
            'Activo' => 'green',
            'Inactivo' => 'red',
        ][$this->status] ?? 'gray';
    }

    public function clase():BelongsTo{

        return $this->belongsTo(Tipo::class,'tipo_id');
    }
    public function servicios(): HasMany{
        return $this->hasMany(Servicio::class,'prioridad_id');
    }
    public function fallas(): HasMany{
        return $this->hasMany(Falla::class,'prioridad_id');
    }
    public function tipo():BelongsTo
    {
        return $this->belongsTo(Tipo::class);
    }
}
