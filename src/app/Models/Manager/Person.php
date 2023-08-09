<?php

namespace App\Models\Manager;

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
    ];

    public function tipoDoc()
    {
        return $this->belongsTo(TipoDoc::class, 'tipo_documento_id');
    }

    public function personas()
    {
        return $this->belongsToMany(Person::class, 'person_programa_social', 'programa_social_id', 'person_id');
    }

    public function tramites(){
        return $this->belongsToMany(Tramite::class, 'person_tramite')
            ->withPivot('rol_tramite_id');
    }

    public function rol_tramite(){
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
}