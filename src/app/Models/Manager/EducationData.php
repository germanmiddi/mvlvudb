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
}
