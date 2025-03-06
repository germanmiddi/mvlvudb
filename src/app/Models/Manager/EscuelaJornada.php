<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EscuelaJornada extends Model
{
    protected $table = 'escuelas_jornadas';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'description',
        'activo',
    ];

    public function escuelas()
    {
        return $this->hasMany(Escuela::class, 'jornada_id');
    }

    public function scopeActive($query)
    {
        return $query->where('activo', true);
    }
}