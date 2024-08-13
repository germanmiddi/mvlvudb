<?php

namespace App\Models\Manager;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GabineteCB extends Model
{
    protected $table = 'gabinetes_cb';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'observacion',
        'legajo_id',
        'estado_id'
    ];

    public function legajo()
    {
        return $this->BelongsTo(LegajoCB::class, 'legajo_id');
    }

    public function estado()
    {
        return $this->BelongsTo(EstadoGabineteCB::class, 'estado_id');
    }

}