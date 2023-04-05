<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Request;
use Illuminate\Foundation\Http\FormRequest as IlluminateFormRequest;
use App\Language;
use Config;

class FormRequest extends IlluminateFormRequest
{
  /**
   * Handle a failed validation attempt.
   *
   * @param \Illuminate\Contracts\Validation\Validator $validator
   *
   * @return void
   */
  protected function failedValidation(Validator $validator)
  {
    throw new HttpResponseException(response()->json($this->errorUnprocessableMultipleEntity($validator), 422));
  }
  public function errorUnprocessableMultipleEntity($validator, $titleMessage = null)
  {

    $errorData = array();
    foreach ($validator->errors()->toArray() as $key => $value) {
      $pointer = 'pointer';

      foreach ($value as $v) {
        if ($titleMessage == null) {
          $jsonErrorMessage['title'] = translateValidationErrorsOfApi($v);
        } else {
          $jsonErrorMessage['title'] = $titleMessage;
        }
        $jsonErrorMessage['detail'] = translateValidationErrorsOfApi($v);;
        $jsonErrorMessage['source'] = [$pointer . '":' . '"'.$key];
        array_push($errorData, $jsonErrorMessage);
      }
    }
    $jsonError['errors'] = $errorData;
    return $this->metaEncode($jsonError);
  }
  protected function metaEncode($response)
  {
    $json1 = json_encode($response, JSON_UNESCAPED_SLASHES);
    $meta = json_encode(Config::get('constants.META'));
    $array1 = json_decode($meta, TRUE);
    $array2 = json_decode($json1, TRUE);
    $data = array_merge_recursive($array1, $array2);
    return $data;
  }
}
