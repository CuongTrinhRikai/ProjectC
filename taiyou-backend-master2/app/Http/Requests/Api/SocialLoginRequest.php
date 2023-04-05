<?php

namespace App\Http\Requests\Api;

use App\Rules\Api\checkClientSecret;
use App\Rules\Api\checkClienttId;
use Illuminate\Http\Request;

class SocialLoginRequest extends FormRequest
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
        return [
            "clientId" => ['required', new checkClienttId],
            "clientSecret" => ['required', new checkClientSecret($request->clientId)],
            "grantType" => 'required|in:social',
            'provider' => 'required|in:facebook,google,apple',
            'accessToken'=>'required',
            'userIdentifier' => 'requiredIf:provider,apple'
        ];
    }
}
