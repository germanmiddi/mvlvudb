<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Manager\CajasEntrevista;

class Padron extends Model
{
    use HasFactory;

    protected $table = 'padrones';

    protected $fillable = [
        'nombre',
        'descripcion',
        'estado_entrevistas',
        'estado_entregas',
        'fecha_inicio',
        'fecha_fin'
    ];

    protected $casts = [
        'estado_entrevistas' => 'string',
        'estado_entregas' => 'string',
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date'
    ];

    /**
     * Relación con las entrevistas de cajas
     */
    public function cajasEntrevistas()
    {
        return $this->hasMany(CajasEntrevista::class);
    }

    /**
     * Scope para padrones activos en entrevistas
     */
    public function scopeActivos($query)
    {
        return $query->where('estado_entrevistas', 'activo');
    }

    /**
     * Scope para padrones activos en entregas
     */
    public function scopeParaEntregas($query)
    {
        return $query->where('estado_entregas', 'activo');
    }

    /**
     * Scope para padrones vigentes (entrevistas activas + fechas válidas)
     */
    public function scopeVigentes($query)
    {
        $now = now()->toDateString();
        return $query->where('estado_entrevistas', 'activo')
                    ->where('fecha_inicio', '<=', $now)
                    ->where(function($q) use ($now) {
                        $q->whereNull('fecha_fin')
                          ->orWhere('fecha_fin', '>=', $now);
                    });
    }

    /**
     * Scope para padrones con entregas vigentes
     */
    public function scopeEntregasVigentes($query)
    {
        $now = now()->toDateString();
        return $query->where('estado_entregas', 'activo')
                    ->where('fecha_inicio', '<=', $now)
                    ->where(function($q) use ($now) {
                        $q->whereNull('fecha_fin')
                          ->orWhere('fecha_fin', '>=', $now);
                    });
    }

    // Métodos helper
    public function isActivoParaEntrevistas()
    {
        return $this->estado_entrevistas === 'activo';
    }

    public function isActivoParaEntregas()
    {
        return $this->estado_entregas === 'activo';
    }
}
