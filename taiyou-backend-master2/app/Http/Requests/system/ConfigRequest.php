<?php

namespace App\Http\Requests\system;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ConfigRequest extends FormRequest
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
        $validate = [];
        if ($request->method() == "POST") {
            $validate = [
                'label' => 'required|unique:configs,label',
                'type' => 'required|in:text,textarea,file,number',
            ];
            if ($request->type == 'file') {
                $validate = array_merge($validate, ['value' => 'required|file|mimes:jpg,png,jpeg,bmp']);
            } else {
                $validate = array_merge($validate, ['value' => 'required']);
            }
        } else {
            $validate = ['value' => 'required'];
        }
        return $validate;
    }
}
