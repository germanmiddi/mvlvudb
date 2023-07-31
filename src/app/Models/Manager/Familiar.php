<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Familiar extends Model
{
    protected $table = 'familiares';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'tramite_id',
        'person_id',
        'parentesco_id',
        'activo'
    ];

    public function tramite()
    {
        return $this->belongsTo(Tramite::class);
    }

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function parentesco()
    {
        return $this->belongsTo(Parentesco::class);
    }
}
