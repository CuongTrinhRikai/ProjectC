<?php
namespace App\Services\System;

use App\Model\Country;
use App\Services\Service;

class CountryService extends Service
{
    public function __construct(Country $country){
        parent::__construct($country);
    }

    public function extractKeyValuePair($countries, $key = 'id', $value = 'name') {
        $countriesPair = array();
        foreach($countries as $country){
            $countriesPair[$country[$key]] = $country[$value];
        }
        return $countriesPair;
      }
}