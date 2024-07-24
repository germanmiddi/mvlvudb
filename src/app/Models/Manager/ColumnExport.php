<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColumnExport extends Model
{
    protected $table = 'columns_export';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'table',
        'columns',
        'label',
        'order'
    ];
}