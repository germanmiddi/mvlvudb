<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Model;

class CajasMotivoSuspension extends Model
{
    protected $table = 'cajas_motivos_suspension';

    protected $fillable = [
        'description',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function cajasEntrevistas()
    {
        return $this->hasMany(CajasEntrevista::class, 'motivo_suspension_id');
    }
}

