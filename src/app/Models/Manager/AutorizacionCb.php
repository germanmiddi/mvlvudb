<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutorizacionCb extends Model
{
    protected $table = 'autorizaciones_cb';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'apoyo_escolar',
        'actividad_empleo',
        'autorizacion_firmada',
        'autorizacion_retirarse',
        'autorizacion_uso_imagen',
        'inscripcion_comedor',
        'comedor_id',
        'legajo_id',
    ];

    public function legajo()
    {
        return $this->hasOne(LegajoCB::class, 'id', 'legajo_id');
    }

    public function comedor ()
    {
        return $this->belongsTo(Comedor::class, 'comedor_id');
    }
}