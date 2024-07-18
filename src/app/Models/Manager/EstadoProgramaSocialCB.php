<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoProgramaSocialCB extends Model
{
    protected $table = 'estados_programa_social_cb';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'description',
        'activo',
    ];

    public function legajo_programa_social()
    {
        return $this->hasMany(LegajoProgramaSocialCB::class, 'estado_id');
    }
}