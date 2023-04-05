<?php

namespace App\Model\System;

use App\Traits\uuidTrait;
use App\Model\System\Guide;
use App\Model\System\Manual;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mansion extends Model
{
    use HasFactory,LogsActivity,uuidTrait;
  protected $guarded = ['id'];

    protected static $logAttributes = ['mansion_name', 'address'];

    protected static $logName = 'Mansion';

    protected static $logOnlyDirty = true;

    protected $fillable = [
        'mansion_id', 'mansion_name', 'address','mansion_phone','contractor_id','created_by','latitude','longitude'
    ];

    public function buildingAdmin()
    {
        return $this->hasMany(BuildingAdminMansion::class);
    }

    public function guides()
    {
        return $this->belongsTo(Guide::class);
    }
    public function contractor()
    {
        return $this->belongsTo(Contractor::class);
    }

    public function checkInCheckOut()
    {
        return $this->hasMany(CheckInCheckOut::class);
    }
    public function manual()
    {
        return $this->hasOne(Manual::class);
    }
    public function mansionGuide()
    {
        return $this->belongsToMany(Guide::class, 'guide_mansions', 'mansion_id', 'instructor_id')->where('status', 1);
    }
    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($mansion) {

            $relationMethods = ['buildingAdmin','manual'];

            foreach ($relationMethods as $relationMethod) {

                if ($mansion->$relationMethod()->count() > 0) {
                    return false;
                }
            }
        });
    }
}
