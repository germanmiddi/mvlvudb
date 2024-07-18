<?php

namespace App\Models\Manager;

use App\Models\User;
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
        'fecha',
        'legajo_programa_social_cb_id',
        'profesional_id'
    ];

    public function legajo_programa_social()
    {
        return $this->BelongsTo(LegajoProgramaSocialCB::class, 'legajo_programa_social_cb_id');
    }

    public function profesional()
    {
        return $this->BelongsTo(User::class, 'profesional_id');
    }
}