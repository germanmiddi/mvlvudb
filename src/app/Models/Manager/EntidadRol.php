<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntidadRol extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];
}
