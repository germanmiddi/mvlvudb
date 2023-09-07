<?php
namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'dependencia_id', 'active']; // Agrega 'active' a los campos modificables

    protected $attributes = [
        'active' => true, // Valor predeterminado: activo
    ];

    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class);
    }
    
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
    
    public function tramites()
    {
        return $this->hasMany(Tramite::class);
    }
}
