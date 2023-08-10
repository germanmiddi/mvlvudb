<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CbjData extends Model
{
    protected $table = 'cbj_data';
    public $timestamps = true;
    protected $hidden = ['id','created_at', 'updated_at'];
    
    protected $fillable = [
        'anio_inicio',
        'aut_firmada',
        'aut_retirarse',
        'aut_uso_imagen',
        'act_empleo',
        'apoyo_escolar',
        'certificado_escolar',
        'estado_cbj_id',
        'comedor_id',
        'tramite_id',
        'acompanamiento_cbj_id',
        'actividad_cbj_id'

    ];

    public function estadoCbj()
    {
        return $this->belongsTo(EstadoCbj::class, 'estado_cbj_id');
    }

    public function comedor ()
    {
        return $this->belongsTo(Comedor::class, 'comedor_id');
    }

    public function tramite()
    {
        return $this->hasOne(Tramite::class, 'tramite_id');
    }

    public function acompanamiento ()
    {
        return $this->belongsTo(AcompanamientoCbj::class, 'acompanamiento_cbj_id');
    }

    public function actividadCbj()
    {
        return $this->belongsTo(ActividadCbj::class, 'actividad_cbj_id');
    }

}