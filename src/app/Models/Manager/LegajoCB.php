<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegajoCB extends Model
{
    protected $table = 'legajos_cb';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'person_id',
        'sede_id',
        'estado_id',
        'canal_atencion_id'
    ];

    protected static function booted()
    {
        static::creating(function ($modelo) {
            if (is_null($modelo->estado_id)) {
                // Buscar el estado por defecto basado en la descripción
                $estado_id = EstadoCbj::where('description', 'Activo')->first();
                if ($estado_id) {
                    $modelo->estado_id = $estado_id->id;
                }
            }
        });
    }

    public function person()
    {
        return $this->BelongsTo(Person::class, 'person_id');
    }

    public function sede()
    {
        return $this->BelongsTo(Sede::class, 'sede_id');
    }

    public function canal_atencion()
    {
        return $this->BelongsTo(CanalAtencion::class, 'canal_atencion_id');
    }

    public function estadocbj()
    {
        return $this->BelongsTo(EstadoCbj::class, 'estado_id');
    }

    public function autorizacion()
    {
        return $this->hasOne(AutorizacionCb::class,'legajo_id', 'id');
    }
}