<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoArticulacion extends Model
{
    use HasFactory;
    protected $table = 'tipo_articulaciones';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'description',
        'activo',
    ];

    /* RELACIONES */
}
