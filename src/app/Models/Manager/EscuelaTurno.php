<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EscuelaTurno extends Model
{
    protected $table = 'escuelas_turnos';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'description',
        'activo',
    ];

    public function cbiData()
    {
        return $this->hasMany(CbiData::class);
    }

    public function escuelas()
    {
        return $this->belongsToMany(Escuela::class, 'escuelas_v2_turnos', 'turno_id', 'escuela_id');
    }

    public function scopeActive($query)
    {
        return $query->where('activo', true);
    }
}