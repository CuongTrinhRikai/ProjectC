<?php

namespace App\Rules\Api;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class checkIn implements Rule
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

//        $buildingIds = DB::table('building_admin_mansions')->where('building_admin_id',$value)->get();
//        dd($buildingIds);
//        $user = $buildingIds->where('mansion_id', '=', $value)->first();
//dd($user);
//        if ($user === null) {
//            return false;
//        }
//        else{
//            return true;
//        }
//
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
