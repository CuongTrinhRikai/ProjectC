<?php

namespace App\Http\Requests\system;

use Illuminate\Foundation\Http\FormRequest;

class setResetRequest extends FormRequest
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
    public function rules()
    {
        return [
            'email' => 'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|max:255|required',
            'password' => ['required','confirmed','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).{8,20}+$/'],
            'password_confirmation' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'password.regex' => translate('Your password must be between 8 - 20 characters long, should contain at least 1 Uppercase, 1 Lowercase, 1 Numeric, and 1 special character.'),
            'password.confirmed' => translate('The password confirmation does not match.'),

            'email.regex' => translate('The Email should be format of example@example.com.'),
            'email.required' => translate('The Email is required.'),
            'email.max' => translate('The Email may not be greater than 255 characters.'),

        ];
    }
}
