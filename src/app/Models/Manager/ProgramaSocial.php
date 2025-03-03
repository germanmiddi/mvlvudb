<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramaSocial extends Model
{
    protected $table = 'programa_social';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'description',
        'activo',
    ];

    // public function programasSociales()
    // {
    //     return $this->belongsToMany(ProgramaSocial::class, 'person_programa_social', 'person_id', 'programa_social_id');
    // }

    public function personas()
    {
        return $this->belongsToMany(Person::class, 'person_programa_social', 'programa_social_id', 'person_id');
    }

    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }
}
