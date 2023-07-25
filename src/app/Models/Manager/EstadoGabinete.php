<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoGabinete extends Model
{
    protected $table = 'estado_gabinete';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'description',
        'activo',
    ];

    public function cbiData()
    {
        return $this->hasMany(CbiData::class);
    }
}