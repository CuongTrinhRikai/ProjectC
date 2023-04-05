<?php

namespace App\Rules\Api;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class checkClienttId implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $clientIds = DB::table('oauth_clients')->pluck('id')->toArray();
        if (!in_array($value, $clientIds)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The client Id is invalid.';
    }
}
