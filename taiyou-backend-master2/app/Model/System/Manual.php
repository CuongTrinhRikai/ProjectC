<?php

namespace App\Model\System;

use App\Model\System\Mansion;
use App\Traits\uuidTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Manual extends Model
{

    use HasFactory,LogsActivity,uuidTrait;
    protected $guarded = ['id'];

      protected static $logAttributes = ['name'];

      protected static $logName = 'Mansion';

      protected static $logOnlyDirty = true;

      protected $fillable = [
          'name', 'mansion_id','url','flag','manual_type','filename','manual_id', 'company_id'
      ];

      public function mansions()
      {
          return $this->belongsTo(Mansion::class,'mansion_id');
      }
    //   protected static function boot()
    //   {
    //       parent::boot();
    //       static::deleting(function($manual) {

    //           if($manual->mansions->count()>0){
    //               return false;
    //           }
    //       });
    //   }
}
