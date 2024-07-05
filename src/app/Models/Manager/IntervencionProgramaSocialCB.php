<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntervencionProgramaSocialCB extends Model
{
    protected $table = 'intervenciones_programa_social_cb';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'description',
        'activo',
        'legajo_programa_social_cb',
        'profesional_id'
    ];
}