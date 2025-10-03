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
        'activo',
        'fecha_inicio',
        'fecha_fin'
    ];

    protected $casts = [
        'activo' => 'boolean',
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
     * Scope para padrones activos
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope para padrones vigentes (fecha actual entre inicio y fin)
     */
    public function scopeVigentes($query)
    {
        $now = now()->toDateString();
        return $query->where('activo', true)
                    ->where('fecha_inicio', '<=', $now)
                    ->where(function($q) use ($now) {
                        $q->whereNull('fecha_fin')
                          ->orWhere('fecha_fin', '>=', $now);
                    });
    }
}
