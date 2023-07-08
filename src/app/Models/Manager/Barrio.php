<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barrio extends Model
{
    protected $table = 'barrios';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'description',
        'localidad_id',
        'postal_code',
    ];

    public function localidad()
    {
        return $this->belongsTo(Localidad::class);
    }
}
