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

    /* public function programasSociales()
    {
        return $this->belongsToMany(ProgramaSocial::class, 'person_programa_social', 'person_id', 'programa_social_id');
    } */
}