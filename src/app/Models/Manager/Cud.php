<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Cud extends Model
{
    protected $table = 'cud';
    public $timestamps = true;
    protected $hidden = ['id','created_at', 'updated_at'];
    
    protected $fillable = [
        'codigo',
        'diagnostico',
        'person_id',
        'posee_cud',
        'presento_cud',
        'vencimiento_cud'
    ];

    public function getFecha()
    {
        return Carbon::parse($this->vencimiento_cud)->format('d/m/Y');
    }

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}