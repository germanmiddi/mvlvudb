<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEnfermedad extends Model
{
    use HasFactory;
    protected $table = 'tipo_enfermedades';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'description',
        'activo',
    ];

    /* RELACIONES */
}
