<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class TramiteData extends Model
{
    protected $table = 'tramite_data';
    protected $fillable = [
        'tramite_id', 'ingreso_nuevo', 'boton_antipanico', 'updated_at', 'created_at'
    ];

    public function tramite()
    {
        return $this->belongsTo(Tramite::class);
    }
}
