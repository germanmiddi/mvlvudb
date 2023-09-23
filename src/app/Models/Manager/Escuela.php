<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Escuela extends Model
{
    protected $table = 'escuelas';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'description',
        'infante',
        'primaria',
        'secundaria',
        'nocturna',
        'dependencia_id',
        'activo',
    ];

    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class);
    }
}