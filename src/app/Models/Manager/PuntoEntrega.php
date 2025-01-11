<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class PuntoEntrega extends Model
{
    use HasFactory;
    protected $table = 'puntos_entrega';
    protected $fillable = ['description', 'activo'];

    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'punto_entrega_usuario');
    }

    public function collections()
    {
        return $this->hasMany(Collection::class);
    }
}
