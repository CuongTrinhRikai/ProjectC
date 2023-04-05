<?php
namespace App\Traits\Api;
use Illuminate\Support\Facades\Request;
use Config;

trait ResponseTrait
{
    protected $statusCode = 200;

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @param null $key
     * @param      $message
     * @param null $titleMessage
     * @return mixed
     */
    protected function respondWithError($message, $code=null, $key=null, $titleMessage=null)
    {
        if ($this->statusCode === 200) {
            trigger_error(
                "You better have a really good reason for erroring on a 200...",
                E_USER_WARNING
            );
        }
        if($key != null) {
            $pointer = 'pointer';
            $error['source'] = $pointer . '":' . '"' . '/data/attributes/' . $key;
            $error['code'] = trans("code.".$key);
        }else{
            $error['code'] = $this->statusCode;
        }

        $error['title'] = is_null($titleMessage) ? $message : $titleMessage;

        $error['detail'] = $message;
        $jsonApiError['errors'][] = $error;


        return $this->metaEncode($jsonApiError);
    }

    public function respondWithSuccess($message = "OK"){
        $data['data'] = [
            'message' => $message
        ];
        return $this->metaEncode($data);
    }

    public function respondWithSuccessFlag($message = "OK"){
        $data['data'] = [
            'message' => $message,
            'hasBusinessCategory' => true,
        ];
        return $this->metaEncode($data);
    }

    public function respondWithSuccessFlagValue($message = "OK", $value){
        $data['data'] = [
            'message' => $message,
            'hasBusinessCategory' => false,
            'businessCategoryText' => $value
        ];
        return $this->metaEncode($data);
    }

    public function userUnauthenticated($message = 'Unauthenticated'){
        $data['error'] = [
            'title' => frontTrans($message),
            'detail' => frontTrans($message),
        ];
        return $this->metaEncode($data);
    }

    protected function metaEncode($response)
    {
        $json1 = json_encode($response);
        $meta = json_encode(Config::get('constants.META'));
        $array1 = json_decode($json1, TRUE);
        $array2 = json_decode($meta, TRUE);
        $data = array_merge_recursive($array2, $array1);
        return $this->respondWithArray($data);


    }

    /**
     * @param array $array
     * @param array $headers
     * @return \Illuminate\Http\Response
     */
    protected function respondWithArray(array $array, array $headers = [])
    {     
        $contentType = 'application/json';
        $content = json_encode($array);
        $response = response()->make($content, $this->statusCode, $headers);

        $response->header('Content-Type', $contentType);

        return $response;
    }

}