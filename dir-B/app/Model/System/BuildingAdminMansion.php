<?php

namespace App\Model\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingAdminMansion extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'building_admin_id', 'mansion_id'
    ];

    public function mansion()
    {
        return $this->belongsTo(Mansion::class,'mansion_id');
    }
}
