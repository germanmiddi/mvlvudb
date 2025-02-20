<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EscuelaV2 extends Model
{
    protected $table = 'escuelas_v2';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'numero/sigla',
        'nombre_completo',
        'direccion',
        'localidad_id',
        'telefono',
        'mail',
        'dependencia_id',
        'activo',
    ];

    public function localidades()
    {
        $this->belongsTo(Localidad::class, 'localidad_id');
    }

    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class, 'dependencia_id');
    }

    public function niveles()
    {
        return $this->belongsToMany(NivelEducativo::class, 'escuelasv2_nivel_educativo', 'escuela_id', 'nivel_educativo_id');
    }

    public function scopeActive($query)
    {
        return $query->where('activo', true);
    }

}
