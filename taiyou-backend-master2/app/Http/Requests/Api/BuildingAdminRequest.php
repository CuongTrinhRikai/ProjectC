<?php

namespace App\Http\Requests\Api;
use Illuminate\Http\Request;

class BuildingAdminRequest extends FormRequest
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
                'home_address' => 'required|string|max:255|min:3',
                'home_phone_number' => 'required|numeric|regex:/^(\+\d{1,3}[- ]?)?\d{10}$/',
                'mobile_number' => 'regex:/^(\+\d{1,3}[- ]?)?\d{11}$/|required|numeric|unique:building_admins,mobile_number,'.\Auth::user()->id,

        ];
    }
}
