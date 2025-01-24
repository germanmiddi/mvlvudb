<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Model;

class TipoTenencia extends Model
{
    protected $table = 'habitacional_tipo_tenencia';

    protected $fillable = ['nombre', 'descripcion'];

    public function cajasEntrevistas()
    {
        return $this->hasMany(CajasEntrevista::class);
    }
}
