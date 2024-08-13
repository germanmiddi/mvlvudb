<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoGabineteCB extends Model
{
    protected $table = 'estados_gabinete_cb';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'description',
        'activo',
    ];

    public function informes()
    {
        return $this->hasMany(GabineteCB::class, 'estado_id');
    }
}