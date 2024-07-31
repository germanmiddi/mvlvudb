<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivoLegajo extends Model
{
    use HasFactory;
    
    protected $table = 'archivos_legajo_cb';
    protected $primaryKey = 'id';
    public $timestamps = true;
    
    protected $fillable = [
        'name',
        'description',
        'ext',
        'legajo_id',
    ];

    public function legajo()
    {
        return $this->belongsTo(LegajoCB::class);
    }
}
