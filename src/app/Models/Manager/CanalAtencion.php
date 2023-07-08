<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CanalAtencion extends Model
{
    protected $table = 'canal_atencion';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'description',
    ];
}