<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntidadParticipante extends Model
{
    use HasFactory;
    protected $fillable = [
        'person_id',
        'entidad_id',
        'entidad_rol_id',
        'estado',
        'observaciones',
        'fecha_inicio',
        'fecha_fin'
    ];

    public function person(){
        return $this->belongsTo(Person::class);
    }

    public function entidad(){
        return $this->belongsTo(Entidad::class);
    }

    public function role(){
        return $this->belongsTo(EntidadRol::class, 'entidad_rol_id');
    }
}
