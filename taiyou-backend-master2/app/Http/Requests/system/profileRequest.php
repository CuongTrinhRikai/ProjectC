<?php

namespace App\Http\Requests\system;

use App\Rules\system\checkOldPassword;
use Illuminate\Foundation\Http\FormRequest;

class profileRequest extends FormRequest
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
            'old_password' => ['required', new checkOldPassword],
            'password' => ['required','confirmed','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).{8,20}+$/'],
            'password_confirmation' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'password.regex' => translate('Your password must be at least 8 characters long, should contain at least 1 Uppercase, 1 Lowercase, 1 Numeric, and 1 special character.'),

        ];
    }
}
