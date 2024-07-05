<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramaSocialCB extends Model
{
    protected $table = 'programas_sociales_cb';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'description',
        'activo',
    ];

    public function legajos(){
        return $this->belongsToMany(LegajoCB::class, 'legajo_programa_social_cb', 'programa_social_id', 'legajo_id')
            ->using(LegajoProgramaSocialCB::class)->withPivot('fecha_inscripcion', 'profesional_id', 'estado_id');
    }
}