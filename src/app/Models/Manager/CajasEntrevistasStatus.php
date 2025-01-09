<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Model;

class CajasEntrevistasStatus extends Model
{

    protected $table = 'cajas_entrevistas_statuses';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function cajasEntrevista()
    {
        return $this->hasMany(CajasEntrevista::class);
    }
}
