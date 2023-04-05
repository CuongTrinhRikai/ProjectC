<?php

namespace App\Http\Requests\system;

use App\Rules\system\wordcount;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class contractorRequest extends FormRequest
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
            'company_name' => [ 'required','string', 'min:3', 'max:255', 'regex:/(?!^\d+$)^.+$/'],
            'sales_staff' => 'nullable',
            'sales_affair' => 'nullable',
            'company_general_affairs' => 'nullable',

        ];

        if ($request->method() == "POST") {
            $validate = array_merge($validate, [
                'contractorId' => 'required|string|min:1|max:255|unique:contractors,contractorId',
            ]);
        }
        if ($request->method() == "PUT") {
            $validate = array_merge($validate, [
                'contractorId' => 'required|string|min:1|max:255|unique:contractors,contractorId,' . $request->contractor,
            ]);
        }
        return $validate;
    }
    public function messages()
    {
        return [

//            'company_name.max' => 'The company name should be less than 255 character. ',
//            'company_name.string' => 'The company name is a required field. ',
//            'contractorId.string' => 'Contractor id is a required field. ',

            'company_name.required' =>translate('The Contractor Company Name is required.'),
            'company_name.string' =>translate('The Contractor Company Name should be string.'),
            'company_name.min' =>translate('The Contractor Company Name must be atleast 3 characters.'),
            'company_name.max' =>translate('The Contractor Company Name may not be greater than 255 characters.'),
            'company_name.regex' =>translate('The Contractor Company Name cannot be number only.'),

            'contractorId.required' =>translate('The Contractor ID is required.'),
            'contractorId.string' =>translate('The Contractor ID should be string.'),
            'contractorId.min' =>translate('The Contractor ID must be atleast 1 characters.'),
            'contractorId.max' =>translate('The Contractor ID may not be greater than 255 characters.'),
            'contractorId.unique' =>translate('The Contractor ID has already been taken.'),



        ];
    }
}
