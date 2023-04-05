<?php

namespace App\Http\Requests\system;


use App\User;
// use App\Rules\system\checkUniqueUsername;
use App\Model\System\Guide;
use Illuminate\Http\Request;
use App\Rules\system\wordcount;
use App\Rules\system\checkUniqueUsername;
use Illuminate\Foundation\Http\FormRequest;

class guideRequest extends FormRequest
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


        if ($request->method() == "POST") {
            // dd($request->all());

            if ($request->contact_category_id == 0 || $request->contact_category_id == 1) {
                $validate = [
                    'line_id' => 'required|unique:guides,line_id|max:20|regex:/^\S*$/u',
                ];

            }
            else{
                $validate = [
                    'line_id' => 'nullable',
                ];

            }
            if ($request->contact_category_id == 1) {
                $validate =array_merge($validate, [
                    'email' => 'nullable',
                ]);
            }
           else{

            $validate = array_merge($validate, [
                'email' => 'required|max:255|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|unique:guides,email',
            ]);
          }




            $validate = array_merge($validate, [
                'contact_category_id' =>'required',
                'mobile_number' => 'required|min:11|max:11|unique:guides,mobile_number',
                'employee_number' => 'required|min:1|unique:guides,employee_number|max:255',
                'name' => ['required','string','max:50', 'min:3', new wordcount, 'regex:/^([^0-9]*)$/'],
            ]);


        }

        if ($request->method() == "PUT") {

            if ($request->contact_category_id == 0 || $request->contact_category_id == 1) {
                $validate = [
                    'line_id' => 'required|max:20|regex:/^\S*$/u|unique:guides,line_id,'. $request->guide,
                ];
            }
            else{
                $validate = [
                    'line_id' => 'nullable|max:20|unique:guides,line_id,'. $request->guide,

                ];
            }
            if ($request->contact_category_id == 1) {
                $validate =array_merge($validate, [
                    'email' => 'nullable',
                ]);
            }
           else{

            $validate = array_merge($validate, [
                'email' => 'required|max:255|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|unique:guides,email,'. $request->guide,
            ]);

          }

            $validate = array_merge($validate, [
                'contact_category_id' =>'required',

                'mobile_number' => 'required|min:11|max:11|unique:guides,mobile_number,' . $request->guide,
                'employee_number' => 'required|max:255|unique:guides,employee_number,' . $request->guide,
                'name' => ['string', 'required', 'max:50', 'min:3', new wordcount, 'regex:/^([^0-9]*)$/'],
            ]);
        }
//    dd($validate);
        return $validate;
    }
    public function messages()
    {
        return [
            'name.regex' => translate('The Contact Guide Name cannot contain numbers.'),
            'name.required' => translate('The Contact Guide Name is required.'),
            'name.string' => translate('The Contact Guide Name should be string.'),
            'name.min' => translate('The Contact Guide Name must be atleast 3 characters.'),
            'name.max' => translate('The Contact Guide Name may not be greater than 50 characters.'),

            'employee_number.required' => translate('The Contact Guide Employee Number is a required. '),
            'employee_number.unique' => translate('The Contact Guide Employee Number has already been taken.'),
            'employee_number.min' => translate('The Contact Guide Employee Number must be atleast 1 characters.'),
            'employee_number.max' => translate('The Contact Guide Employee Number may not be greater than 255 characters.'),

            'mobile_number.required' =>translate( 'The Contact Guide Mobile Number is required. '),
            'mobile_number.min' => translate(' The Contact Guide Mobile Number must be 11 digit number.'),
            'mobile_number.max' => translate(' The Contact Guide Mobile Number must be 11 digit number.'),
            'mobile_number.unique' => translate('The Contact Guide Mobile Number has already been taken.'),

            'contact_category_id.required' => translate('The Contact Guide Category is a required.'),

            'email.regex' => translate('The Email should be format of example@example.com.'),
            'email.required' => translate('The Email is required.'),
            'email.unique' => translate('The Email has already been taken.'),
            'email.max' => translate('The Email may not be greater than 255 characters.'),

            'line_id.required' => translate('The Line ID is required.'),
            'line_id.unique' => translate('The Line ID has already been taken.'),
            'line_id.max' => translate('The Line ID may not be greater than 20 characters.'),
            'line_id.regex' => translate('The Line ID should should not contain space.'),




        ];
    }
}
