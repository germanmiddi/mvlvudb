<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaludData extends Model
{
    protected $table = 'salud_data';
    public $timestamps = true;
    protected $hidden = ['id','created_at', 'updated_at'];
    
    protected $fillable = [
        'apto_medico',
        'libreta_vacunacion',
        'observacion',
        'fecha_apto_medico',
        'electrocardiograma',
        'fecha_electrocardiograma',
        'medicacion',
        'name_medicacion',
        'dosis',
        'person_id',
        'centro_salud_id',
        'estado_salud_id'
    ];

    public function centroSalud()
    {
        return $this->belongsTo(CentroSalud::class);
    }

    public function estadoSalud()
    {
        return $this->belongsTo(EstadoSalud::class);
    }

    public function person()
    {
        return $this->hasOne(Person::class);
    }
}