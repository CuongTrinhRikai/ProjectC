<?php
namespace App\Services\Api;

use App\Exceptions\Api\ApiGenericException;
use App\Exceptions\Api\EmailIdNotFound;
use AppleSignIn\ASDecoder;

class AppleLoginService
{
    public function appleUserData($accessToken, $userIdentifier)
    {
            $userData = ASDecoder::getAppleSignInPayload($accessToken);
            $isValid = $userData->verifyUser($userIdentifier);

            if (!$isValid) {
               throw new ApiGenericException('Invalid apple user.'); 
            }
            $email = $userData->getEmail();
            if (empty($email)) {
                throw new EmailIdNotFound();
            }
            $userData['provider'] = 'apple';
            return $userData;
    
    }
}