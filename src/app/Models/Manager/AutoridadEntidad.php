<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutoridadEntidad extends Model
{
    protected $table = 'autoridades_entidades';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'phone',
        'cargo_id',
        'entidad_id',
        'activo',
    ];

    public function entidad()
    {
        return $this->belongsTo(Entidad::class);
    }

    public function cargo()
    {
        return $this->belongsTo(CargoAutoridad::class);
    }

}