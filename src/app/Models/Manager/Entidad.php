<?php

namespace App\Models\Manager;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Entidad extends Model
{

    //use SoftDeletes;

    protected $table = 'entidades';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'num_entidad',
        'name',
        'objeto',
        'address',
        'phone',
        'email',
        'solicitud_inscripcion',
        'personeria',
        'eximision',
        'observation',
        'fecha_inscripcion',
        'fecha_fundacion',
        'fecha_fin_mandato',
        'fecha_memoria',
        'fecha_asamblea',
        'tipo_entidad_id',
        'localidad_id',
        'tipo_actividad_id',
        'activo'

    ];

    protected $with = ['participantes', 'participantes.role', 'participantes.person'];

    public function participantes()
    {
        return $this->hasMany(EntidadParticipante::class);
    }

    public function localidad()
    {
        return $this->belongsTo(Localidad::class, 'localidad_id');
    }

    public function tipoActividad()
    {
        return $this->belongsTo(TipoActividad::class, 'tipo_actividad_id');
    }

    public function tipoEntidad()
    {
        return $this->belongsTo(TipoEntidad::class,'tipo_entidad_id');
    }

    public function autoridades()
    {
        return $this->hasMany(AutoridadEntidad::class);
    }
}
