<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servicepricelist extends Model
{
    protected $fillable = [
        'detail',
        'type',
        'wait_time',
        'baggage',
        'guide',
        'passenger_capacity',
        'duration',
        'price'
    ];
    
    protected $casts = [
        'baggage' => 'boolean',
        'guide'   => 'boolean',
        'active'  => 'boolean'
    ];    
    
    protected $dates = [
        'deleted_at',
        'price_valid_to'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    use HasFactory, SoftDeletes;
}
