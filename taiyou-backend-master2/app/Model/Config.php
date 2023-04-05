<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Config extends Model
{
    use LogsActivity;

    protected $fillable = [
        'label', 'type', 'value', 'company_id'
    ];

    protected static $logAttributes = ['label', 'type', 'value'];

    protected static $logName = 'Config';

    protected static $logOnlyDirty = true;

    public function getDescriptionForEvent(string $eventName): string
    {
        return logMessage('Config', $this->id, $eventName);
    }
    public function isFile($type)
    {
        if (strtolower($type) == 'file') {
            return true;
        } else {
            return false;
        }
    }
    public function isText($type)
    {
        if (strtolower($type) == 'text') {
            return true;
        } else {
            return false;
        }
    }
    public function isTextArea($type)
    {
        if (strtolower($type) == 'textarea') {
            return true;
        } else {
            return false;
        }
    }
    public function isNumber($type)
    {
        if (strtolower($type) == 'number') {
            return true;
        } else {
            return false;
        }
    }
    public function isColorPicker($label)
    {
        if ($label == 'cms theme color') {
            return true;
        } else {
            return false;
        }
    }
    public function isDefault($id)
    {
        if (in_array($id, [1, 2, 3])) {
            return true;
        } else {
            return false;
        }
    }
}
