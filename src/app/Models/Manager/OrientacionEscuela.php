<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrientacionEscuela extends Model
{
    protected $table = 'orientaciones_escuela';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'description',
        'activo',
    ];

    public function saludData()
    {
        return $this->hasMany(SaludData::class);
    }
}