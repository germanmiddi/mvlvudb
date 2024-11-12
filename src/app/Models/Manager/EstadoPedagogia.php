<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoPedagogia extends Model
{
    use HasFactory;

    protected $table = 'estado_pedagogia';

    protected $fillable = [
        'description',
    ];

    public function pedagogia()
    {
        return $this->hasMany(LegajoPedagogia::class);
    }
}
