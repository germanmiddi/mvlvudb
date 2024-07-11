<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoActividadCB extends Model
{
    protected $table = 'estados_actividad_cb';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'description',
        'activo',
    ];

    public function actividad_legajo()
    {
        return $this->hasMany(ActividadCBLegajo::class, 'estado_id');
    }
}