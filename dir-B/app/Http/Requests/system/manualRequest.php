<?php

namespace App\Http\Requests\system;

use Illuminate\Http\Request;
use App\Rules\system\checkUrl;
use Illuminate\Foundation\Http\FormRequest;

class manualRequest extends FormRequest
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

        if ($request->manual_type == 1) {
            $validate = [
                'url' => 'max:102400|mimes:pdf'
            ];

        } else {
            $validate = [
                'url' => 'max:204800|mimes:mp4'
            ];
        }

        $validate = array_merge($validate, [
            'manual_id' => 'required|max:255',
            'name' => 'required|max:255|min:3',
            'manual_type' => 'required',
            'flag' => 'required'
        ]);

        return $validate;
    }

    public function messages()
    {
        return [

            'flag.required' => translate('The status field is required.'),
            'manual_type.required' =>translate('The Manual Type field is required.'),
        ];
    }
    public function withValidator($validator)
    {

        $validator->after(function ($validator) {
            $request = request();
            if ($request->old_filename) {
                $ext = explode(".", $request->old_filename);

                if (($request->manual_type == 0) && ($ext[1] == 'pdf') && $request->original_name == null) {

                    $validator->errors()->add('manual_type', translate('Invalid Manual type'));

                }
                if (($request->manual_type == 1) && ($ext[1] == 'mp4') && $request->original_name == null) {

                    $validator->errors()->add('manual_type', translate('Invalid Manual type'));
                }
            }

        });

    }
}
