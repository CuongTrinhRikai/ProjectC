<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity;

class Log extends Activity
{
    protected $table = 'activity_log';

    public function getModuleName($data)
    {
        if (isset($data)) {
            $data = explode("\\", $data);
            $moduleName = $data[array_key_last($data)];
        } else {
            $moduleName = 'N/A';
        }
        return $moduleName;
    }

    function getNameFromDescription($description)
    {
        $content = explode('by', $description);
        $content = explode('at', $content[0]);
        return ucfirst(trim($content[0]));
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'causer_id', 'id');
    }

    public function oldValues($rawValues)
    {
        if (!isset($rawValues['old'])) {
            return 'N/A';
        }
        $value = trim(json_encode($rawValues['old']), '{}');
        $string = str_replace(',', "\n", $value);
        return nl2br($string);
    }

    public function newValues($rawValues)
    {
        // if(!isset($rawValues['old'])) return 'N/A';
        $value = trim(json_encode($rawValues['attributes']), '{}');
        $string = str_replace(',', "\n", $value);
        return nl2br($string);
    }
}
