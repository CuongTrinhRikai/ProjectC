<?php

namespace App\Rules\system;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class wordcount implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        if (strlen($value) != strlen(utf8_decode($value))) {
            $str = array_filter(explode("　",trim($value)),function($item){
                if($item) return $item;
            });

            if(count($str)<=1){
                return false;
            }

            return true;
        }

        else {
            $trimmed = trim($value);
            $numWords = count(explode(' ', $trimmed));
            if($numWords  == 2 ||$numWords  > 2){
                return true;
            }

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

        return 'Name must be minimum of two word.';
    }
}
