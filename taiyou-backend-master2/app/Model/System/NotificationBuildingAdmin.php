<?php

namespace App\Model\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationBuildingAdmin extends Model
{
    use HasFactory;


    protected $guarded = ['id'];
    protected $table = 'building_admin_notifications';

    protected $fillable = [
        'building_admin_id', 'notification_id'
    ];

    public function buildingAdmins()
    {
        return $this->belongsTo(BuildingAdmin::class);
    }
    public function notifications()
    {
        return $this->belongsTo(Notification::class,'notification_id');
    }
}
