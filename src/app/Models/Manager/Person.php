<?php

namespace App\Models\Manager;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{

    protected $table = 'person';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = [
        'lastname',
        'name',
        'fecha_nac',
        'num_documento',
        'num_cuit',
        'tipo_documento_id',
        'genero'
    ];

    protected $appends = ['age'];

    public function getAgeAttribute()
    {
        return Carbon::parse($this->fecha_nac)->age;
    }

    // Relaciones.

    public function tipoDoc()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipo_documento_id');
    }

    // public function personas()
    // {
    //     return $this->belongsToMany(Person::class, 'person_programa_social', 'programa_social_id', 'person_id');
    // }

    public function programaSocial()
    {
        return $this->belongsToMany(ProgramaSocial::class, 'person_programa_social', 'person_id', 'programa_social_id');
    }

    public function tramites()
    {
        return $this->belongsToMany(Tramite::class, 'person_tramite')
            ->withPivot('rol_tramite_id');
    }

    public function rol_tramite()
    {
        return $this->belongsToMany(RolTramite::class, 'person_tramite');
    }

    public function contact()
    {
        return $this->hasMany(ContactData::class);
    }

    public function address()
    {
        return $this->hasMany(AddressData::class);
    }

    public function aditional()
    {
        return $this->hasMany(AditionalData::class);
    }

    public function education()
    {
        return $this->hasMany(EducationData::class);
    }

    public function social()
    {
        return $this->hasMany(SocialData::class);
    }

    public function cud()
    {
        return $this->hasOne(Cud::class);
    }

    public function salud()
    {
        return $this->hasOne(SaludData::class);
    }

    public function legajo_cb()
    {
        return $this->hasOne(LegajoCB::class);
    }

    public function collections()
    {
        return $this->hasMany(Collection::class);
    }

    public function entrevista()
    {
        return $this->hasOne(CajasEntrevista::class);
    }

}