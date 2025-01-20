<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class _PersonProgramaSocial extends Pivot
{
    protected $table = 'person_programa_social';
    protected $primaryKey = ['person_id', 'programa_social_id'];
    public $incrementing = false;
    public $timestamps = true;
}