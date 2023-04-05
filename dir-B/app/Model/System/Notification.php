<?php

namespace App\Model\System;

use App\Traits\uuidTrait;
use App\Model\System\Contractor;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Model\System\BuildingAdminMansion;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory,LogsActivity,uuidTrait;


      protected static $logAttributes = ['title', 'body'];

      protected static $logName = 'Notification';

      protected static $logOnlyDirty = true;

      protected $fillable = [
          'title', 'body', 'name_of_registrant','flag','building_admin_id','contractor_id','notification_id', 'company_id'
      ];

      public function notificationbuildingAdmin()
    {
        return $this->belongsToMany(BuildingAdmin::class, 'building_admin_notifications', 'notification_id','building_admin_id' );
    }
    public function notificationcontractor()
    {
        return $this->belongsToMany(Contractor::class, 'contractor_notifications', 'notification_id', 'contractor_id');
    }
    public  static function getContractorFromBuildingAdmin($contractor)
    {
        return BuildingAdmin::select(DB::raw('CAST(id AS CHAR) AS building_id'))-> where('contractor_id', $contractor)->pluck('building_id');
    }

    public  static function getBuildingAdminFromCompany($company_id)
    {
        return BuildingAdmin::select(DB::raw('CAST(id AS CHAR) AS building_id'))->whereHas('contractor', function ($query) use ($company_id) {
            $query->where('company_id', $company_id);
        })->pluck('building_id');
    }



    //   protected static function boot()
    //   {
    //       parent::boot();
    //       static::deleting(function ($mansion) {

    //           $relationMethods = ['buildingAdmin','contractor'];

    //           foreach ($relationMethods as $relationMethod) {

    //               if ($mansion->$relationMethod()->count() > 0) {
    //                   return false;
    //               }
    //           }
    //       });
    //   }
}
