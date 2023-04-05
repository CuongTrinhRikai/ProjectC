<?php

namespace App\Http\Requests\system;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class emailTemplateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Request $request)
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
            'title' => 'required',
            'from' => 'email',
            'multilingual.*.subject' => 'required',
            'multilingual.*.template' => 'required',
        ];

        if ($request->method() == "POST") {
            $validate = array_merge($validate, [
                'code' =>
                    [
                        'required',
                        Rule::unique('email_templates')
                            ->where('company_id',$request->company_id),
                    ],
            ]);
        }

        if ($request->method() == "PUT") {
            $validate = array_merge($validate, [
                'code' =>
                    [
                        'required',
                        Rule::unique('email_templates')
                            ->where('company_id',$request->company_id)
                            ->ignore($request->code,'code'),
                    ],
            ]);
        }
        return $validate;
    }
    public function messages()
    {
        return [
            "multilingual.*.subject.required" => translate("The subject field is required."),
            "multilingual.*.template.required" => translate("The template field is required.")
        ];
    }
}
