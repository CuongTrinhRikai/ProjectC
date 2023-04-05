<?php

namespace App\Model\System;

use App\Model\Company;
use App\Traits\uuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Contractor extends Model
{
    use HasFactory,LogsActivity ,uuidTrait;
    protected $guarded = ['id'];

    protected static $logAttributes = ['company_name', 'phone','address'];

    protected static $logName = 'Contractor';

    protected static $logOnlyDirty = true;

    protected $fillable = [
        'company_name','contractorId', 'company_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function buildingAdmin()
    {
        return $this->hasOne(BuildingAdmin::class, 'contractor_id', 'id');
    }

    public function mansions()
    {
        return $this->hasMany(Mansion::class, 'contractor_id', 'id');
    }

    public function contractorGuide()
    {
        return $this->belongsToMany(Guide::class, 'contractor_guides', 'contractor_id', 'guide_id')->where('status', 1)->withPivot('type');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function($contractor) {
            $relationMethods = ['buildingAdmin','mansions'];
            foreach ($relationMethods as $relationMethod) {

                if ($contractor->$relationMethod()->count() > 0) {
                    return false;
                }
            }
        });
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
