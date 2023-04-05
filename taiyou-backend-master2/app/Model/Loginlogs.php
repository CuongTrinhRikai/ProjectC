<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Loginlogs extends Model
{
    protected $fillable = [
        'user_id', 'ip', 'city', 'country', 'isp', 'lat', 'lon', 'timezone', 'region_name'
    ];


    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
