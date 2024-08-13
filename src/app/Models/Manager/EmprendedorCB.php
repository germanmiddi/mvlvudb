<?php

namespace App\Models\Manager;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmprendedorCB extends Model
{
    protected $table = 'emprendedores_cb';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'fecha_inscripcion',
        'fecha_finalizacion',
        'participa',
        'legajo_id'
    ];

    public function legajo()
    {
        return $this->BelongsTo(LegajoCB::class, 'legajo_id');
    }

}