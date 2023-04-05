<?php

namespace App\Traits;

use Ramsey\Uuid\Uuid;

trait uuidTrait
{
    /**
     * Boot function from Laravel.
     */
    protected static function bootuuidTrait()
    {
             static::creating(function ($model) {

            $model->uuid =Uuid::uuid4()->toString();
        });

    }

    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing()
    {
        return true;
    }
    /**
     * Get the auto-incrementing key type.
     *
     * @return string
     */
    public function getKeyType()
    {
        return 'string';
    }
}
