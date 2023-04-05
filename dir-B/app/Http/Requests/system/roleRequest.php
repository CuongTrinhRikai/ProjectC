<?php

namespace App\Http\Requests\system;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class roleRequest extends FormRequest
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
        $validate =  [
            'permissions' => 'required',
        ];

        if ($request->method() == "POST") {
            $validate = array_merge($validate, [
                'name' => 'required|min:3|max:50|alpha|unique:roles,name',
            ]);
        }
        if ($request->method() == "PUT") {
            $validate = array_merge($validate, [
                'name' => 'required|min:3|max:50|alpha|unique:roles,name,'.$request->role,
            ]);
        }

        return $validate;
    }
    public function messages()
    {
        return [
            'name.required' => translate('The Role Name is required.'),
            'name.min' => translate('The Role Name must be at least 3 characters.'),
            'name.max' => translate('The Role Name may not be greater than 50 characters.'),
            'name.alpha' => translate('The Role Name can only contain letters.'),
            'name.unique' => translate('The Role Name has already been taken.'),
            'permissions.required' => translate('Please select the permissions.')
        ];
    }
}
