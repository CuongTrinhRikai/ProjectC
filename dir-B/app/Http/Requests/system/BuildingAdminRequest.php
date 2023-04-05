<?php

namespace App\Http\Requests\system;

use Illuminate\Http\Request;
use App\Rules\system\wordcount;
use App\Helper\Ekcms\validationHelper;
use Illuminate\Foundation\Http\FormRequest;


class BuildingAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules(Request $request)
    {

        $validate = [
            'name' => ['required','string', 'max:255', new wordcount, 'regex:/^([^0-9]*)$/'],
            'mansion_id' => 'required',
            'contractor_id' => 'required',
            'business_category' => 'required',


        ];

        if ($request->method() == "POST") {
            $validate = array_merge($validate, [
                'username' => 'required|regex:/^\S*$/u|min:3|max:50|unique:building_admins,username',
                //'password' => ['required','confirmed','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).{8,20}+$/'],
                'password' => ['required','confirmed','regex:/^[0-9]{4,128}+$/'],
                'password_confirmation' => 'required'
//                'home_phone_number' => 'required|numeric|regex:/^(\+\d{1,3}[- ]?)?\d{10}$/',
//                'mobile_number' => 'regex:/^(\+\d{1,3}[- ]?)?\d{11}$/|required|numeric|unique:building_admins,mobile_number',
//                'home_address' => 'required|string|max:255|min:3',
            ]);

        }
        if ($request->method() == "PUT") {
            $validate = array_merge($validate, [
                'username' => 'required|regex:/^\S*$/u|min:3|max:50|unique:building_admins,username,'.$request->building,
//                'home_phone_number' => 'required|numeric|regex:/^(\+\d{1,3}[- ]?)?\d{10}$/',
//                'mobile_number' => 'regex:/^(\+\d{1,3}[- ]?)?\d{11}$/|required|numeric|unique:building_admins,mobile_number,'.$request->building,
//                'home_address' => 'required|string|max:255|min:3',
            ]);
        }


        return $validate;

    }

    public function messages()
    {
        return [
            'username.required' => translate('The Building Admin ID is required.'),
            'username.min' => translate('The Building Admin ID must be atleast 3 characters.'),
            'username.max' => translate('The Building Admin ID may not be greater than 50 characters.'),
            'username.unique' => translate('The Building Admin ID has already been taken.'),
            'username.regex' => translate('The Building Admin ID cannot contain space.'),

            'name.required' => translate('The Building Admin Name is required.'),
            'name.string' => translate('The Building Admin Name must be a string.'),
            'name.max' => translate('The Building Admin Name may not be greater than 255 characters.'),
            'name.regex' => translate('The Building Admin Name cannot have number.'),

            'contractor_id.required' => translate('The Contractor is required.'),
            'mansion_id.required' => translate('The Mansion is required.'),
            'business_category.required' => translate('The Business Category is required.'),

            'password.regex' => translate('Your password must be between 8 - 20 characters long, should contain at least 1 Uppercase, 1 Lowercase, 1 Numeric, and 1 special character.'),

        ];
    }
}
