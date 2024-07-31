<?php

namespace App\Models\Manager;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformeCB extends Model
{
    protected $table = 'informes_cb';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'description',
        'fecha_informe',
        'activo',
        'legajo_id',
        'profesional_id',
        'estado_id'
    ];

    public function legajo()
    {
        return $this->BelongsTo(LegajoCB::class, 'legajo_id');
    }

    public function profesional()
    {
        return $this->BelongsTo(User::class, 'profesional_id');
    }

    public function estado()
    {
        return $this->BelongsTo(EstadoInformeCB::class, 'estado_id');
    }
}