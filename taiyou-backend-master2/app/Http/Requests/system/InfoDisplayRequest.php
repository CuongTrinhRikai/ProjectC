<?php

namespace App\Http\Requests\system;

use Illuminate\Http\Request;
use App\Rules\system\wordcount;
use App\Helper\Ekcms\validationHelper;
use Illuminate\Foundation\Http\FormRequest;


class InfoDisplayRequest extends FormRequest
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
        if ($request->check_out == "" || $request->check_out == "N/A")
        {
            $validate = [
                'check_in' => 'required',
            ];
        }

        else{
            $validate = [
                'check_in' => 'required',
                'check_out' => 'date|after:check_in',
            ];
        }

        return $validate;

    }

    public function messages()
    {
        return [
            'check_out.after' => translate('The check out must be a time after check in.')
        ];
    }
}
