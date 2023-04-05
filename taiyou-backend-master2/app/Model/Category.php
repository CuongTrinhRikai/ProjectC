<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Category extends Model
{
    use LogsActivity;

    protected $guarded = ['id'];

    protected static $logAttributes = ['name', 'attributes'];
    
    protected static $logName = 'Category';

    protected static $logOnlyDirty = true;

    public function getDescriptionForEvent(string $eventName): string
    {
        return logMessage('Category',$this->id,$eventName);
    }

    public function subCategoryCount($id){
        return $this->where('parent_id', $id)->count();
    }

    public function child(){
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
}
