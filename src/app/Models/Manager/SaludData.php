<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaludData extends Model
{
    protected $table = 'salud_data';
    public $timestamps = true;
    
    protected $fillable = [
        'apto_medico',
        'libreta_vacunacion',
        'observacion',
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