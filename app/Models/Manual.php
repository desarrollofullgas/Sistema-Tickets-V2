<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manual extends Model
{
    use HasFactory;

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id','categoria','sub_categoria', 'titulo_manual', 'manual_path', 'size', 'flag_trash','mime_type'
    ];
	public function scopeSearch($query, $value)
    {
        $query->where(function ($query) use ($value) {
            $query->where('id', 'like', "%{$value}%")
                ->orWhere('titulo_manual', 'like', "%{$value}%")
                ->orWhere('categoria', 'like', "%{$value}%")
                ->orWhere('sub_categoria', 'like', "%{$value}%")
                ->orWhere('created_at', 'like', "%{$value}%");
        })->orWhere(function ($query) use ($value) {
            $query->whereIn('user_id', function ($subquery) use ($value) {
                $subquery->select('id')
                    ->from('users')
                    ->where('id', 'LIKE', "%{$value}%");
            });
        });
    }

    public function getCreatedFormatAttribute()
    {
        return $this->created_at->format('d-m-Y H:i:s');
    }

    protected $appends = [
        'created_format',
    ];

    public function panel()
    {
        return $this->belongsTo(Panel::class);
    }
	public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function permisos()
    {
        return $this->belongsToMany(Permiso::class)->withPivot('id', 'manual_id', 'permiso_id', 'created_at')->using(ManualPermiso::class);
    }
}
