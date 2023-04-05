<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class EmailTemplateTranslation extends Model
{    
    protected $fillable = [
        'email_template_id', 'language_code', 'subject', 'template'
    ];
}
