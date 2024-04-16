<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrigenDemanda extends Model
{
    use HasFactory;
    protected $table = 'origen_demandas';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'description',
        'activo',
    ];

    /* RELACIONES */
}
