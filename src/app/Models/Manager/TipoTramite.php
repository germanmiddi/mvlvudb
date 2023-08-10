<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoTramite extends Model
{
    protected $table = 'tipo_tramite';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'description',
        'dependencia_id',
        'activo',
    ];

    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class);
    }

    public function tramites(){
        return $this->hasMany(Tramite::class);
    }

    public function scopeActive($query)
    {
        return $query->where('activo', '1');
    }    

}