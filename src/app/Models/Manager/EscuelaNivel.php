<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EscuelaNivel extends Model
{
    protected $table = 'escuelas_niveles';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'description',
        'cbi',
        'cbj',
        'activo',
    ];

    public function cbiData()
    {
        return $this->hasMany(CbiData::class);
    }
}