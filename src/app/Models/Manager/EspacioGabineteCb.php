<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EspacioGabineteCb extends Model
{
    use HasFactory;
    protected $table = 'espacio_gabinete_cb';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'description',
        'activo',
    ];

    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }
}
