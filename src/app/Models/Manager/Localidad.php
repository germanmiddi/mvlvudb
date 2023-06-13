<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    protected $table = 'localidades';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'description',
        'postal_code',
    ];
}