<?php

namespace App;

use App\Model\Company;
use App\Model\Log;
use App\Model\Role;
use App\Model\System\Guide;
use App\Model\UserPassword;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Config;
use Laravel\Passport\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'role_id', 'token', 'password_resetted','image', 'user_type',
        'name_jp', 'company_id'
    ];

    protected $guarded = [
        'id'
    ];

    protected static $logAttributes = ['name', 'email', 'username', 'role_id', 'image', 'user_type', 'name_jp'];

    protected static $ignoreChangedAttributes = ['password', 'password_resetted', 'token', 'remember_token', 'updated_at'];

    protected static $logName = 'User';

    protected static $logOnlyDirty = true;

    public function getDescriptionForEvent(string $eventName): string
    {
        return logMessage('User', $this->id, $eventName);
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function userPasswords()
    {
        return $this->hasMany(UserPassword::class, 'user_id', 'id');
    }

    public function logs()
    {
        return $this->hasMany(Log::class, 'causer_id', 'id');
    }

    public function loginLogs()
    {
        return $this->hasMany(Log::class, 'user_id', 'id');
    }

    public function getPasswordSetResetLink($check = false, $token)
    {
        $title = 'Reset Password';
        $key = 'reset-password';
        if ($check) {
            $title = 'Set Password';
            $key = 'set-password';
        }
        $link =  ''.Config::get('constants.URL')."/".Config::get('constants.PREFIX')."/".$key."/".$this->email."/".$token.'';
        return "<a href=".$link.">".$title."</a>";
    }

    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }
    public function guide(){
        return $this->hasMany(Guide::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
