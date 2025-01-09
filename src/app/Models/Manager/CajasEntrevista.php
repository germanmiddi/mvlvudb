<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class CajasEntrevista extends Model
{
   
    protected $table = 'cajas_entrevistas';

    protected $fillable = [
        'person_id',
        'fecha',
        'entrevistador_id',
        'puntos_entrega_id',
        'status_id',
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
        'discapacidad'
    ];

    protected $with = [
        'person',
        'entrevistador',
        'puntosEntrega',
        'status',
        'statusUpdatedBy',
        'createdBy',
    ];

    protected $casts = [
        'vive_solo' => 'boolean',
        'tiene_pami' => 'boolean',
        'tiene_obra_social' => 'boolean',
    ];

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id');
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

}
