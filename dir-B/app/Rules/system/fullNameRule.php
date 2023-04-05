<?php

namespace App\Rules\system;

use Illuminate\Contracts\Validation\Rule;

class fullNameRule implements Rule
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

        $trimmed = trim($value);
        $numWords = count(explode(' ', $trimmed));
        if($numWords  == 2 ||$numWords  > 2){
            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {

        return 'The Building Admin Name must be minimum of two word.';
    }
}
