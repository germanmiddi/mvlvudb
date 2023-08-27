<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TramiteEstado extends Model
{
    use HasFactory;

    protected $table = 'tramite_estados';

    protected $fillable = [
        'description',
    ];

    public function tramites()
    {
        return $this->hasMany(Tramite::class, 'estado_id');
    }
}
