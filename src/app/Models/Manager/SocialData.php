<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialData extends Model
{
    protected $table = 'social_data';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $hidden = ['id','created_at', 'updated_at'];

    protected $fillable = [
        'person_id',
        'tipo_ocupacion_id',
        'cobertura_medica_id',
        'programa_social_id',
        'subsidio',
        'tipo_pension_id',
    ];

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }

    public function tipoOcupacion()
    {
        return $this->belongsTo(TipoOcupacion::class, 'tipo_ocupacion_id');
    }

    public function coberturaMedica()
    {
        return $this->belongsTo(CoberturaMedica::class, 'cobertura_medica_id');
    }

    public function tipoPension()
    {
        return $this->belongsTo(TipoPension::class, 'tipo_pension_id');
    }

    public function programaSocial()
    {
        return $this->belongsTo(ProgramaSocial::class, 'programa_social_id');
    }
}