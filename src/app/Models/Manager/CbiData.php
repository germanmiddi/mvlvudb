<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CbiData extends Model
{
    protected $table = 'cbi_data';
    public $timestamps = true;
    protected $hidden = ['id','created_at', 'updated_at'];
    
    protected $fillable = [
        'anio_inicio',
        'aut_firmada',
        'aut_retirarse',
        'aut_uso_imagen',
        'act_varias',
        'act_esporadicas',
        'comedor',
        'estado_cbi_id',
        'estado_gabinete_id',
        'tramite_id'
    ];

    public function estadoCbi()
    {
        return $this->belongsTo(EstadoCbi::class, 'estado_cbi_id');
    }

    public function estadoGabinete()
    {
        return $this->belongsTo(EstadoGabinete::class, 'estado_gabinete_id');
    }

    public function tramite()
    {
        return $this->hasOne(Tramite::class, 'tramite_id');
    }
}