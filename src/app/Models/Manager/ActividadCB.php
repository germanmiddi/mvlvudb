<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActividadCB extends Model
{
    protected $table = 'actividades_cb';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'description',
        'activo',
    ];

    public function legajos(){
        return $this->belongsToMany(LegajoCB::class, 'actividad_cb_legajo', 'actividad_id', 'legajo_id')
            ->using(LegajoProgramaSocialCB::class)->withPivot('fecha_inscripcion', 'profesional_id', 'estado_id');
    }
}