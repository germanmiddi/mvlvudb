<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cud extends Model
{
    protected $table = 'cud';
    public $timestamps = false;

    protected $fillable = [
        'codigo',
        'diagnostico',
        'person_id'
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}