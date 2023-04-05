<?php

namespace App\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class FrontendUser extends Authenticatable
{
    use Notifiable, HasApiTokens;
    protected $table = 'frontend_users';
    protected $guard = 'frontendUsers';
    protected $fillable = [
        'name', 'username', 'email', 'password', 'provider', 'provider_user_id'
    ];
}
