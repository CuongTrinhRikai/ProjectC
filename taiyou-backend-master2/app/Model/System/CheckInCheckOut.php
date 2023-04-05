<?php

namespace App\Model\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckInCheckOut extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'building_admin_id', 'mansion_id', 'latitude', 'longitude', 'token', 'check_in', 'check_out', 'business_category'
    ];

    public function buildingAdmin()
    {
        return $this->belongsTo(BuildingAdmin::class, 'building_admin_id', 'id');
    }

    public function mansion()
    {
        return $this->belongsTo(Mansion::class, 'mansion_id', 'id');
    }

}
