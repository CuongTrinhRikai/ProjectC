<?php

namespace App\Http\Requests\Api;

use App\Rules\Api\checkIn;
use Illuminate\Http\Request;

class CheckInCheckOutRequest extends FormRequest
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
         $validate =[
            'mansion_id' => 'required',
            'contractorId' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ];

        return $validate;

    }

    public function messages()
    {
        return [
            'mansion_id.required' => frontTrans('The mansion is not assigned.'),
            'contractorId.required' => frontTrans('The contractor is not assigned.'),
            'latitude.required' => frontTrans('The latitude is required.'),
            'longitude.required' => frontTrans('The longitude is required.'),

        ];
    }
}
