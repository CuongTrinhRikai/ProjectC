<?php

namespace App\Http\Requests\system;

use Illuminate\Http\Request;
use App\Rules\system\wordcount;
use Illuminate\Foundation\Http\FormRequest;

class notificationRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:65535',
            'name_of_registrant' => ['required', 'string', 'max:50', 'min:3', new wordcount, 'regex:/^([^0-9]*)$/'],
            'flag' => 'required'
        ];
        if ($request->flag == 0) {
            $validate = array_merge($validate, [
                'contractor_id' => 'required_without:building_admin_id',
                'building_admin_id' => 'required_without:contractor_id',
            ]);
        }

        return $validate;
    }

    public function messages()
    {
        return [

            'title.required' => translate('The title is required.'),
            'title.string' => translate('The title should be string.'),
            'title.min' => translate('The title must be atleast 3 characters.'),
            'title.max' => translate('The title may not be greater than 255 characters.'),

            'body.required' => translate('The content is required.'),
            'body.string' => translate('The content should be string.'),
            'body.max' => translate('The content is too long.'),

            'name_of_registrant.regex' => translate('The Registrant Name should not contain number.'),
            'name_of_registrant.required' => translate('The Registrant Name is required.'),

            'name_of_registrant.max' => translate('The Registrant Name may not be greater than 50 characters.'),

            'contractor_id.required_without' => translate('The contractor  is required.'),
            'building_admin_id.required_without' => translate('The building admin is required .'),

            'flag.required' => translate('The flag is required.'),

        ];
    }

}
