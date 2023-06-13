<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    protected $table = 'sedes';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'description',
        'dependencia_id',
    ];

    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class, 'dependencia_id');
    }

    public function tramites(){
        return $this->hasMany(Tramite::class);
    }
}