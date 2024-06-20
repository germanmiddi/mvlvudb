<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoLegajoCb extends Model
{
    protected $table = 'tipos_legajo_cb';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'description',
        'activo'
    ];
}