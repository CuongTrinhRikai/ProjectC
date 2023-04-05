<?php

namespace App\Rules\Api;

use Illuminate\Contracts\Validation\Rule;
use DB;

class checkClientSecret implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($clientId)
    {
        $this->clientId = $clientId;
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
        $client = DB::table('oauth_clients')->where('id', $this->clientId)->first();
        if (isset($client) && $client->secret == $value) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The client secret is invalid.';
    }
}
