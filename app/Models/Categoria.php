<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name'];
	
	public function scopeSearch($query, $value){
        $query->where('id', 'like', "%{$value}%")
            ->orWhere('name', 'like', "%{$value}%")
            ->orWhere('status', 'like', "%{$value}%")
            ->orWhere('created_at', 'like', "%{$value}%");
    }
    public function getStatusColorAttribute(){
        return[
            'Activo' => 'green',
            'Inactivo' => 'red',
        ][$this->status] ?? 'gray';
    }

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
    public function correos():HasMany
    {
        return $this->hasMany(CorreosZona::class)->orderBy('zona_id','ASC');
    }
    public function correosAgrupados():HasMany{
        return $this->hasMany(CorreosZona::class)->select('correo_id')->groupBy('correo_id');
    }
    public function zonas():HasMany{
        return $this->hasMany(CorreosZona::class)->select('zona_id')->groupBy('zona_id');
    }
}
