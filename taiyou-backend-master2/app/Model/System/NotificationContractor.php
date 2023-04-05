<?php

namespace App\Model\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationContractor extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $fillable = [
        'contractor_id', 'notification_id'
    ];

    public function contractors()
    {
        return $this->belongsTo(Contractor::class);
    }
}
