<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    protected $table = 'tipo_documento';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'description'
    ];
}