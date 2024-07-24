<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoInformeCB extends Model
{
    protected $table = 'estados_informe_cb';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'description',
        'activo',
    ];

    public function informes()
    {
        return $this->hasMany(InformeCB::class, 'estado_id');
    }
}