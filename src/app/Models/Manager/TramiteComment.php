<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class TramiteComment extends Model
{
    protected $table = 'tramite_comments';
    protected $fillable = [
        'tramite_id', 'user_id', 'dependencia_id', 'content', 'updated_at', 'created_at'
    ];

    public function tramite()
    {
        return $this->belongsTo(Tramite::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class);
    }
}
