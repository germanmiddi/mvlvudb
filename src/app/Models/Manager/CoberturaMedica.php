<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoberturaMedica extends Model
{
    protected $table = 'cobertura_medica';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'description',
    ];
}