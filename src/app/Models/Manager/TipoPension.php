<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPension extends Model
{
    protected $table = 'tipo_pension';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'description',
    ];
}