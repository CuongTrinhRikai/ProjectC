<?php

namespace App\Rules\system;

use App\User;
use App\Model\System\Guide;
use Illuminate\Contracts\Validation\Rule;

class checkUniqueUsername implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($guideid)
    {
        $this->guideid = $guideid;
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

        return User::where('username',$value)->first();
    //    return Guide::where('id', $this->guideid)->where('user_id',$user)->first();


    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The username has  already been  taken.';
    }
}
