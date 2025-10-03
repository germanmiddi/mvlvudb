<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Padron;
class CajasEntrevista extends Model
{

    protected $table = 'cajas_entrevistas';

    protected $fillable = [
        'person_id',
        'padron_id',
        'fecha',
        'entrevistador_id',
        'puntos_entrega_id',
        'status_id',
        'motivo_suspension_id',
        'status_updated_by',
        'status_updated_at',
        'created_by',
        'estudios',
        'vive_solo',
        'cant_convivientes',
        'tenencia',
        'pago_inquilino',
        'ambientes',
        'trabajo',
        'ingresos_trabajo',
        'otra_actividad',
        'tiene_pami',
        'tiene_obra_social',
        'obra_social',
        'tratamiento_medico',
        'medicacion',
        'discapacidad',
        'ingresos_planes',
        'habitacional_tipo_tenencia_id',
        'has_hijos',
        'cant_hijos',
        'cant_personas_trabajando',
        'conviviente_discapacidad',
        'observaciones',
        'actividades'
    ];

    protected $with = [
        'person',
        'padron',
        'entrevistador',
        'puntosEntrega',
        'status',
        'motivoSuspension',
        'statusUpdatedBy',
        'createdBy',
        'tipoTenencia'
    ];

    protected $casts = [
        'vive_solo' => 'boolean',
        'tiene_pami' => 'boolean',
        'tiene_obra_social' => 'boolean',
        'has_hijos' => 'boolean',
        'conviviente_discapacidad' => 'boolean',
        'discapacidad' => 'boolean',

    ];

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }

    public function padron()
    {
        return $this->belongsTo(Padron::class, 'padron_id');
    }

    public function entrevistador()
    {
        return $this->belongsTo(User::class, 'entrevistador_id');
    }

    public function puntosEntrega()
    {
        return $this->belongsTo(PuntoEntrega::class, 'puntos_entrega_id');
    }

    public function status()
    {
        return $this->belongsTo(CajasEntrevistasStatus::class, 'status_id');
    }

    public function statusUpdatedBy()
    {
        return $this->belongsTo(User::class, 'status_updated_by');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function tipoTenencia()
    {
        return $this->belongsTo(TipoTenencia::class, 'habitacional_tipo_tenencia_id');
    }

    public function motivoSuspension()
    {
        return $this->belongsTo(CajasMotivoSuspension::class, 'motivo_suspension_id');
    }
}
