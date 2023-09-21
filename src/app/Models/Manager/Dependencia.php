<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dependencia extends Model
{
    protected $table = 'dependencias';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'description',
        'activo',
    ];

    public function tipoTramite()
    {
        return $this->hasMany(TipoTramite::class);
    }
    
    public function categories()
    {
        return $this->hasMany(Category::class, 'dependencia_id');
    }

    public function escuela()
    {
        return $this->hasMany(Escuela::class);
    }
}