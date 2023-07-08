<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    use HasFactory;
    
    protected $table = 'archivos';
    protected $primaryKey = 'id';
    public $timestamps = true;
    
    protected $fillable = [
        'name',
        'description',
        'ext',
        'tramite_id',
    ];

    public function tramite()
    {
        return $this->belongsTo(Tramite::class);
    }
}
