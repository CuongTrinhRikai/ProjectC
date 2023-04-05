<?php

namespace App\Http\Requests\system;

use App\Rules\system\checkEmail;
use App\Rules\system\fullNameRule;
use App\Rules\system\nameRule;
use App\Rules\system\usernameRule;
use App\Rules\system\wordcount;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Driver\WriteOperationFailedException;

class userRequest extends FormRequest
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
            'name' => ['required','min:3','max:50',new wordcount,'regex:/^([^0-9]*)$/'],
            'role_id' => 'required',
        ];

        if ($request->method() == "POST") {
            $validate = array_merge($validate, [
                'username' => 'regex:/^\S*$/u|required|min:3|max:50|unique:users,username',
                'email' => 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|max:255|required|unique:users,email',
                'image' => 'image|mimes:jpg,png,jpeg,gif',
            ]);
        }
        if ($request->method() == "PUT") {
            $validate = array_merge($validate, [
                'username' => 'regex:/^\S*$/u|required|min:3|max:50|unique:users,username,'.$request->user,
                'email' => 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|max:255|required|unique:users,email,'.$request->user,
                'image' => 'image|mimes:jpg,png,jpeg,gif',
            ]);
        }

        if ($request->set_password_status == 1) {
            $validate = array_merge($validate, [
                'password' => ['required','confirmed','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).{8,20}+$/'],
                'password_confirmation' => 'required'
            ]);
        }

        return $validate;
    }

    public function messages()
    {
        return [
            'name.required' => translate('The Full Name is required.'),
            'name.string' => translate('The Full Name must be a string.'),
            'name.max' => translate('The Full Name may not be greater than 50 characters.'),
            'name.regex' => translate('The Full Name cannot have number.'),

            'role_id.required' => translate('The Role is required.'),

            'username.required' => translate('The Username is required.'),
            'username.min' => translate('The Username must be atleast 3 characters.'),
            'username.max' => translate('The Username may not be greater than 50 characters.'),
            'username.unique' => translate('The Username has already been taken.'),
            'username.regex' => translate('The Username cannot contain space.'),

            'image.mimes' => translate('The Image must be a file of type: jpg, png, jpeg, gif.'),
            'image.image' => translate('The Image must must be an image.'),

            'email.regex' => translate('The Email should be format of example@example.com.'),
            'email.required' => translate('The Email is required.'),
            'email.unique' => translate('The Email has already been taken.'),
            'email.max' => translate('The Email may not be greater than 255 characters.'),

            'password.regex' => translate('Your password must be between 8 - 20 characters long, should contain at least 1 Uppercase, 1 Lowercase, 1 Numeric, and 1 special character.'),

        ];
    }
}
