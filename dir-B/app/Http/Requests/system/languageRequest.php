<?php

namespace App\Http\Requests\system;

use App\Rules\system\checkCountryExist;
use Illuminate\Foundation\Http\FormRequest;

class languageRequest extends FormRequest
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
            'country_id' => ['required', new checkCountryExist],
            'language_code' => 'required|unique:languages,language_code',
            'group' => 'required|in:backend,frontend'
        ];
    }

    public function messages(){
        return [
            'country_id.required' => translate('The country field is required.'),
            'language_code.required' => translate('The language field is required.'),
            'language_code.unique' => translate('The selected language already exists.'),

        ];
    }
}
