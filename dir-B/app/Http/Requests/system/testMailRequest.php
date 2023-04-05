<?php

namespace App\Http\Requests\system;

use Illuminate\Foundation\Http\FormRequest;

class testMailRequest extends FormRequest
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
            'fromemail' => 'email|required|max:255',
            'fromname' => 'string|required|max:255',
            'toemail' => 'email|required|max:255',
            'toname' => 'string|required|max:255',
            'subject' => 'string|required|max:255',
            'body' => 'required|string',
        ];
    }
}
