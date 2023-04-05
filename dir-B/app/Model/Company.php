<?php

namespace App\Model;

use App\Model\System\Contractor;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Company extends Model
{
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'company_id', 'id');
    }

    public function contractos()
    {
        return $this->hasMany(Contractor::class, 'company_id', 'id');
    }
}
