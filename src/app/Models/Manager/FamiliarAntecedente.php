<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamiliarAntecedente extends Model
{
    use HasFactory;
    protected $table = 'familiar_antecedentes';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'description',
        'activo',
    ];

    /* RELACIONES */
}
