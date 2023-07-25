<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cud extends Model
{
    protected $table = 'cbi_data';
    public $timestamps = true;
    
    protected $fillable = [
        'anio_inicio',
        'aut_firmada',
        'aut_retirarse',
        'aut_uso_imagen',
        'act_varias',
        'act_esporadica',
        'comedor',
        'estado_cbi_id',
        'estado_gabinete'
    ];

    public function estadoCbi()
    {
        return $this->belongsTo(EstadoCbi::class);
    }

    public function estadoGabinete()
    {
        return $this->belongsTo(EstadoGabinete::class);
    }

    public function tramite()
    {
        return $this->hasOne(Tramite::class);
    }
}