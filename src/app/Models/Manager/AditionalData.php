<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AditionalData extends Model
{
    protected $table = 'aditional_data';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $hidden = ['id','created_at', 'updated_at'];

    protected $fillable = [
        'person_id',
        'cant_hijos',
        'tipo_vivienda_id',
        'tipo_vinculo_familiar_id',
        'situacion_conyugal_id',
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function tipoVivienda()
    {
        return $this->belongsTo(TipoVivienda::class);
    }

    public function tipoVinculoFamiliar()
    {
        return $this->belongsTo(TipoVinculoFamiliar::class);
    }

    public function situacionConyugal()
    {
        return $this->belongsTo(SituacionConyugal::class);
    }
}