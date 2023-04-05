<?php

namespace App\Model\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MansionGuide extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'guide_mansions';

    protected $fillable = [
        'mansion_id', 'instructor_id'
    ];


}
