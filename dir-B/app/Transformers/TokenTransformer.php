<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class TokenTransformer extends TransformerAbstract
{
  public function transform($data)
  {
    return [
      'tokenType' => $data['token_type'],
      'expiresIn' => $data['expires_in'],
      'accessToken' => $data['access_token'],
      'refreshToken' => $data['refresh_token']
    ];
  }
}
