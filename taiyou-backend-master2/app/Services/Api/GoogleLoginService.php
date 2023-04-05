<?php
namespace App\Services\Api;

use App\Exceptions\Api\EmailIdNotFound;
use GuzzleHttp\Client;

class GoogleLoginService
{
    public function googleUserData($accessToken){
        $http = new Client();
        $url = "https://www.googleapis.com/oauth2/v3/tokeninfo?id_token=" . $accessToken;
        $response = $http->get(
            $url
        );
        $data = json_decode((string) $response->getBody(), true);
        $data['provider'] = 'google';
        if (empty($data['email'])) {
            throw new EmailIdNotFound();
        }
        return $data;
    }
}