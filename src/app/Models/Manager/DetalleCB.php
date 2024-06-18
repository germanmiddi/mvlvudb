<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCB extends Model
{
    protected $table = 'detalles_cb';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'fecha_inscripcion',
        'fecha_inicio',
        'observacion',
        'legajo_id'
    ];

    public function legajo_cb()
    {
        return $this->BelongsTo(LegajoCB::class, 'legajo_id');
    }
}