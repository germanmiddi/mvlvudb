<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegajoPedagogia extends Model
{
    use HasFactory;

    protected $table = 'legajo_pedagogia';

    protected $fillable = [
        'legajo_id',
        'realizo_prueba',
        'fecha_prueba',
        'estado_id',
        'detalles',
        'profesional',
    ];
    
    public function legajo()
    {
        return $this->BelongsTo(LegajoCB::class, 'legajo_id');
    }
    
    public function estado()
    {
        return $this->BelongsTo(EstadoPedagogia::class, 'estado_id');
    }
}
