<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parentesco extends Model
{
    protected $table = 'parentescos';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'description',
    ];
}
