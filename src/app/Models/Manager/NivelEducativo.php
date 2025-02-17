<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NivelEducativo extends Model
{
    protected $table = 'nivel_educativo';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'description',
    ];


    public function escuela()
    {
        return $this->belongsToMany(EscuelaV2::class, 'escuelasv2_nivel_educativo', 'nivel_educativo_id', 'escuela_id');
    }
}