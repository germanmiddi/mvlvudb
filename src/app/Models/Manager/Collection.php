<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Collection extends Model
{
    use HasFactory;
    protected $table = 'collections';
    protected $fillable = ['person_id', 'address', 'date', 'punto_entrega_id', 'product_id', 'user_id'];

    protected $with = ['person', 'puntoEntrega', 'product', 'user'];
    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function puntoEntrega()
    {
        return $this->belongsTo(PuntoEntrega::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
