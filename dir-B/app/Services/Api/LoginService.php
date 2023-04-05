<?php

namespace App\Services\Api;

use Nyholm\Psr7\Response as Psr7Response;
use League\OAuth2\Server\AuthorizationServer;
use Psr\Http\Message\ServerRequestInterface;

class LoginService
{
    public function __construct(
        ServerRequestInterface $request,
        AuthorizationServer $server,
        GoogleLoginService $google,
        FacebookLoginService $facebook,
        AppleLoginService $apple,
        SocialService $service
    ) {
        $this->serverRequest = $request;
        $this->server = $server;
        $this->google = $google;
        $this->facebook = $facebook;
        $this->apple = $apple;
        $this->service = $service;
    }

    public function parseFormat($data)
    {
        $data['client_id'] = $data['clientId'];
        $data['client_secret'] = $data['clientSecret'];
        $data['grant_type'] = $data['grantType'];

        unset($data['clientId'], $data['clientSecret'], $data['grantType']);
        return $data;
    }
    public function generateToken($data)
    {

        $response = $this->server->respondToAccessTokenRequest($this->serverRequest->withParsedBody($data), new Psr7Response);
        return json_decode((string)$response->getBody(), true);
    }

    public function loginWithGoogle($request)
    {
        $googleUserData = $this->google->googleUserData($request->accessToken);
        return $this->socialLoginFurtherProcessing($request, $googleUserData);
    }

    public function loginWithFacebook($request)
    {
        $facebookUserData = $this->facebook->facebookUserData($request->accessToken);
        return $this->socialLoginFurtherProcessing($request, $facebookUserData);
    }

    public function loginWithApple($request)
    {
        $appleUserData = $this->apple->appleUserData($request->accessToken, $request->userIdentifier);
        return $this->socialLoginFurtherProcessing($request, $appleUserData);
    }

    public function socialLoginFurtherProcessing($request, $socialUserData)
    {
        $user = $this->service->setOrGetUser($socialUserData);
        $parsedData = $this->parseFormat($request->only('clientId', 'clientSecret', 'grantType'));
        $parsedData['provider'] = $user->provider;
        $parsedData['provider_user_id'] = $user->provider_user_id;
        return $this->generateToken($parsedData);
    }
}
