<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactData extends Model
{
    protected $table = 'contact_data';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $hidden = ['id','created_at', 'updated_at'];

    protected $fillable = [
        'phone',
        'celular',
        'email',
        'person_id',
    ];

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id');
    }
}