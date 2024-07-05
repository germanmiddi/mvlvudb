<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class LegajoProgramaSocialCB extends Pivot
{
    protected $table = 'legajo_programa_social_cb';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'fecha_inscripcion',
        'legajo_id',
        'programa_social_id',
        'profesional_id',
        'estado_id'
    ];

    public function estado_programa()
    {
        return $this->belongsTo(EstadoProgramaSocialCb::class, 'estado_id');
    }
}
