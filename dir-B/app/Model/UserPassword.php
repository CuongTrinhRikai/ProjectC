<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserPassword extends Model
{
    protected $fillable = [
        'user_id', 'password'
    ];

    public function users()
    {
        return $this->belongsTo(USer::class, 'user_id', 'id');
    }
}
