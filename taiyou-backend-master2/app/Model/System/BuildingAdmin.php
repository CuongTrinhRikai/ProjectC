<?php

namespace App\Model\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class BuildingAdmin extends Authenticatable
{
    use HasFactory,LogsActivity,HasApiTokens;
    public $timestamps = FALSE;
    protected $guarded = ['id'];

    protected static $logAttributes = ['name', 'account_id', 'username', 'email'];

    protected static $ignoreChangedAttributes = ['password', 'password_resetted', 'updated_at'];

    protected static $logName = 'buildingAdmin';

    protected static $logOnlyDirty = true;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'business_category' => 'array',
    ];

    protected $fillable = [
        'name', 'account_id', 'username', 'contractor_id', 'business_category', 'password', 'Password_resetted'
    ];


    public function contractor()
    {
        return $this->belongsTo(Contractor::class,'contractor_id','id');
    }


    public function buildingAdminMansion()
    {
        return $this->belongsToMany(Mansion::class, 'building_admin_mansions', 'building_admin_id', 'mansion_id');
    }

    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }

    public function checkInCheckOut()
    {
        return $this->hasMany(CheckInCheckOut::class, 'building_admin_id');
    }

    public function getMansion()
    {
        return $this->buildingAdminMansion()->pluck('mansion_name');
    }
}
