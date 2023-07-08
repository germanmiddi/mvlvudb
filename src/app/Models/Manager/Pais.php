<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $table = 'paises';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'description'
    ];
}