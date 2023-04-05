<?php

namespace App\Model\System;

use App\User;
use App\Traits\uuidTrait;
use App\Model\System\Mansion;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guide extends Model
{
    use HasFactory, LogsActivity, uuidTrait;
    protected $guarded = ['id'];

    protected static $logAttributes = ['employee_number', 'mobile_number'];

    protected static $logName = 'Guide';

    protected static $logOnlyDirty = true;

    protected $hidden = ['password_confirmation'];

    protected $fillable = [
        'contact_category_id', 'employee_number', 'mobile_number', 'line_id', 'uuid', 'user_id', 'name', 'email', 'status'
    ];

    // public function mansions()
    // {
    //     return $this->hasMany(Mansion::class,'instructor_id');
    // }
    public function mansionGuide()
    {
        return $this->belongsToMany(Mansion::class, 'guide_mansions', 'instructor_id', 'mansion_id');
    }
    public function contractorGuide()
    {
        return $this->belongsToMany(Contractor::class, 'contractor_guides', 'guide_id','contractor_id')->withPivot('type');
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function contractorsSalesAffairs()
    // {
    //     return $this->hasMany(Contractor::class, 'sales_affairs');
    // }

    // public function contractorsSalesStaff()
    // {
    //     return $this->hasMany(Contractor::class, 'sales_staff');
    // }

    // public function contractorsCompanyGeneralAffairs()
    // {
    //     return $this->hasMany(Contractor::class, 'company_general_affairs');
    // }


    protected static function boot()
    {

        parent::boot();
        static::deleting(function ($guide) {


            $relationMethods = ['mansionGuide','contractorGuide'];

            foreach ($relationMethods as $relationMethod) {
                if ($guide->$relationMethod()->count() > 0) {
                    return false;
                }
            }
        });
    }
}
