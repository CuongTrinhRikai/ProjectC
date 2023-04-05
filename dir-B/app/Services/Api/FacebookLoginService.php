<?php

namespace App\Services\Api;

use App\Exceptions\Api\EmailIdNotFound;
use GuzzleHttp\Client;

class FacebookLoginService
{
    public function facebookUserData($accessToken)
    {

        $http = new Client();
        $url = "https://graph.facebook.com/v7.0/me?fields=id,name,email,picture,first_name,last_name,short_name";
        $response = $http->request('GET', $url, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization'=> "Bearer ".$accessToken
            ]
        ]);
        $data = json_decode((string) $response->getBody(), true);
        $data['provider'] = 'facebook';
        if (empty($data['email'])) {
            throw new EmailIdNotFound();
        }
        return $data;
    }
}
