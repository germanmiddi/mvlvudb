<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoEducativo extends Model
{
    protected $table = 'estado_educativo';
    protected $primaryKey = 'id';
    public $timestamps = true;
    
    protected $fillable = [
        'description',
    ];
}