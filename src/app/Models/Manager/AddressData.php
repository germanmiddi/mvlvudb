<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddressData extends Model
{
    protected $table = 'address_data';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $hidden = ['id','created_at', 'updated_at'];

    protected $fillable = [
        'person_id',
        'calle',
        'number',
        'piso',
        'dpto',
        'latitude',
        'longitude',
        'google_address',
        'localidad_id',
        'pais_id',
        'barrio_id',
    ];

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }

    public function localidad()
    {
        return $this->belongsTo(Localidad::class, 'localidad_id');
    }

    public function pais()
    {
        return $this->belongsTo(Paises::class, 'pais_id');
    }

    public function barrio()
    {
        return $this->belongsTo(Barrios::class, 'barrio_id');
    }
}
