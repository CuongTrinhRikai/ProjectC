<?php

namespace App\Model\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractorGuide extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $fillable = [
        'contractor_id', 'guide_id','type'
    ];
}
