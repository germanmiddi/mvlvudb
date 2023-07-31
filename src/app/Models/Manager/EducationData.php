<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationData extends Model
{
    protected $table = 'education_data';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'beca',
        'person_id',
        'nivel_educativo_id',
        'estado_educativo_id',
        'escuela_id',
        'escuela_dependencia_id',
        'escuela_localidad_id',
        'escuela_nivel_id',
        'escuela_turno_id',
        'permanencia',
        'certificado_escolar',
        'observacion'

    ];

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }

    public function nivelEducativo()
    {
        return $this->belongsTo(NivelEducativo::class, 'nivel_educativo_id');
    }

    public function estadoEducativo()
    {
        return $this->belongsTo(EstadoEducativo::class, 'estado_educativo_id');
    }

    public function escuelaDependencia()
    {
        return $this->belongsTo(EscuelaDependencia::class, 'escuela_dependencia_id');
    }

    public function escuelaLocalidad()
    {
        return $this->belongsTo(Localidad::class, 'escuela_localidad_id');
    }

    public function escuelaNivel()
    {
        return $this->belongsTo(EscuelaNivel::class, 'escuela_nivel_id');
    }

    public function escuelaTurno()
    {
        return $this->belongsTo(EscuelaTurno::class, 'escuela_turno_id');
    }
}
