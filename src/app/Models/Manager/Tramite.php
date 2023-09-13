<?php

namespace App\Models\Manager;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tramite extends Model
{
    protected $table = 'tramites';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'fecha',
        'observacion',
        'sede_id',
        'canal_atencion_id',
        'tipo_tramite_id',
        'tipo_institucion_id',
        'person_id',
        'dependencia_id',
        'parentesco_id',
        'estado_id',
        'num_tramite_legacy',
        'assigned',
        'modalidad_atencion_id',
        'category_id',
        'updated_at'
    ];

    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    public function canalAtencion()
    {
        return $this->belongsTo(CanalAtencion::class);
    }

    public function tipoTramite()
    {
        return $this->belongsTo(TipoTramite::class);
    }
    
    
    public function rol_tramite(){
        return $this->belongsToMany(RolTramite::class, 'person_tramite');
    }
    
    public function archivos()
    {
        return $this->hasMany(Archivo::class);
    }
    
    public function persons(){
        return $this->belongsToMany(Person::class, 'person_tramite')
            ->withPivot('rol_tramite_id');
    }

    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class);
    }

    public function parentesco()
    {
        return $this->belongsTo(Parentesco::class);
    }

    public function cbi_data()
    {
        return $this->hasOne(CbiData::class, 'tramite_id', 'id');
    }

    public function cbj_data()
    {
        return $this->hasOne(CbjData::class, 'tramite_id', 'id');
    }
    
    /* protected $casts = [
        'fecha' => 'datetime:d-m-Y',
    ]; */

    public function getFecha()
    {
        return Carbon::parse($this->fecha)->format('d/m/Y');
    }

    public function familiares()
    {
        return $this->hasMany(Familiar::class);
    }

    public function contactos()
    {
        return $this->hasMany(ContactoEmergencia::class);
    }

    public function comments()
    {
        return $this->hasMany(TramiteComment::class);
    }

    public function estado()
    {
        return $this->belongsTo(TramiteEstado::class, 'estado_id');
    }    

    public function modalidadAtencion()
    {
        return $this->belongsTo(ModalidadAtencion::class, 'modalidad_atencion_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }


}
