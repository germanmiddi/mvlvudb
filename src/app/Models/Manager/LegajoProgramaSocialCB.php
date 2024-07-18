<?php

namespace App\Models\Manager;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegajoProgramaSocialCB extends Model
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

    public function legajo()
    {
        return $this->BelongsTo(LegajoCB::class, 'legajo_id');
    }

    public function programa_social()
    {
        return $this->BelongsTo(ProgramaSocialCB::class, 'programa_social_id');
    }

    public function profesional()
    {
        return $this->BelongsTo(User::class, 'profesional_id');
    }

    public function estado()
    {
        return $this->BelongsTo(EstadoProgramaSocialCB::class, 'estado_id');
    }

    public function intervenciones()
    {
        return $this->hasMany(IntervencionProgramaSocialCB::class, 'legajo_programa_social_cb_id');
    }


}
