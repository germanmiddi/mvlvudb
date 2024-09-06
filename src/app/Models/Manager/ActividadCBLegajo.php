<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ActividadCBLegajo extends Pivot
{
    protected $table = 'actividad_cb_legajo';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'fecha_inscripcion',
        'legajo_id',
        'actividad_id',
        'estado_id'
    ];

    public function estado()
    {
        return $this->belongsTo(EstadoActividadCB::class, 'estado_id');
    }

    public function actividad()
    {
        return $this->BelongsTo(ActividadCB::class, 'actividad_id');
    }
}
