<?php

namespace App\Http\Requests\Api;

use App\Rules\Api\checkClientSecret;
use App\Rules\Api\checkClienttId;
use App\Rules\Api\checkUserExists;
use Illuminate\Http\Request;

class LoginRequest extends FormRequest
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

        if ($request->grantType == 'password') {

            return [
                "clientId" => ['required', new checkClienttId($request->clientId)],
                "clientSecret" => ['required', new checkClientSecret($request->clientId)],
                "grantType" => 'required|in:password',
                "username" => ['requiredIf:grantType,password', new checkUserExists($request->password, $request->username)],
                "password" => 'required'
            ];
        }

        return [
            "clientId" => ['required', new checkClienttId],
            "clientSecret" => ['required', new checkClientSecret($request->clientId)],
            "grantType" => 'required|in:refresh_token',
            'refreshToken' => 'required'
        ];

    }
}
