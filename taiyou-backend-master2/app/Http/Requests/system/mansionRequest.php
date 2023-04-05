<?php

namespace App\Http\Requests\system;

use Illuminate\Http\Request;
use App\Rules\system\wordcount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class mansionRequest extends FormRequest
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
            'address' => 'required|string|regex:/(?!^\d+$)^.+$/|max:255|min:3',
            'contractor_id' => 'required',
        ];

        if ($request->method() == "POST") {
           if($request->mansion_phone == null) {
               $validate = array_merge($validate, [
                   'mansion_id' => 'required|max:255|min:1',
                   'mansion_name' => 'required|string|max:255|min:3|regex:/(?!^\d+$)^.+$/|unique:mansions,mansion_name',
               ]);
           }
           else{
               $validate = array_merge($validate, [
                   'mansion_id' => 'required|max:255|min:1',
                   'mansion_name' => 'required|string|max:255|min:3|regex:/(?!^\d+$)^.+$/|unique:mansions,mansion_name',
                   //'mansion_phone' => 'regex:/^(\+\d{1,3}[- ]?)?\d{10}$/|numeric|unique:mansions,mansion_phone',
                   'mansion_phone' => 'regex:/^(\+\d{1,3}[- ]?)?\d{10}$/|numeric'
               ]);
           }
        }
        if ($request->method() == "PUT") {
            if($request->mansion_phone == null){
                $validate = array_merge($validate, [
                    'mansion_id' => 'required|max:255|min:1',
                    'mansion_name' => 'required|string|max:255|min:3|regex:/(?!^\d+$)^.+$/|unique:mansions,mansion_name,'.$request->mansion,
                ]);
            }
            else{
                $validate = array_merge($validate, [
                    'mansion_id' => 'required|max:255|min:1',
                    'mansion_name' => 'required|string|max:255|min:3|regex:/(?!^\d+$)^.+$/|unique:mansions,mansion_name,'.$request->mansion,
                    //'mansion_phone' => 'regex:/^(\+\d{1,3}[- ]?)?\d{10}$/|numeric|unique:mansions,mansion_phone,'.$request->mansion,
                    'mansion_phone' => 'regex:/^(\+\d{1,3}[- ]?)?\d{10}$/|numeric'
                ]);
            }
        }

        return $validate;

    }
        public function messages()
    {
        return [
//            'mansion_name.string' => 'contractor is required.',

            'mansion_id.required' => translate('The Mansion ID is required.'),
            'mansion_id.min' => translate('The Mansion ID must be atleast 3 characters.'),
            'mansion_id.max' => translate('The Mansion ID may not be greater than 255 characters.'),
            'mansion_id.unique' => translate('The Mansion ID has already been taken.'),

            'mansion_name.required' =>translate('The Mansion Name is required.'),
            'mansion_name.string' =>translate('The Mansion Name should be string.'),
            'mansion_name.min' =>translate('The Mansion Name must be atleast 3 characters.'),
            'mansion_name.max' =>translate('The Mansion Name may not be greater than 255 characters.'),
            'mansion_name.regex' =>translate('The Mansion Name cannot be number only.'),
            'mansion_name.unique' =>translate('The Mansion Name has already been taken.'),

//            'mansion_phone.max' =>translate('The Mansion Phone number must be 10 digit number.'),

//            'mansion_phone.required' =>translate('The Mansion Phone number is required.'),
            'mansion_phone.regex' =>translate('The Mansion Phone number must be 10 digit number.'),
            'mansion_phone.numeric' =>translate('The Mansion Phone number must be numeric.'),
            'mansion_phone.unique' =>translate('The Mansion Phone number has already been taken.'),

            'address.required' =>translate('The Mansion Address is required.'),
            'address.string' =>translate('The Mansion Address must be string.'),
            'address.regex' =>translate('The Mansion Address cannot be number only.'),
            'address.numeric' =>translate('The Mansion Address must be numeric.'),
            'address.unique' =>translate('The Mansion Address has already been taken.'),
            'address.min' =>translate('The Mansion Address must be atleast 3 characters.'),
            'address.max' =>translate('The Mansion Address may not be greater than 255 characters.'),

            'contractor_id.required' => translate('The Contractor is required.'),




        ];
    }
}
