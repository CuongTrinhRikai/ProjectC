<?php

namespace App\Services\Api;

use App\Exceptions\ResourceNotFoundException;
use App\Model\System\Guide;
use App\Model\System\Mansion;
use App\Services\Service;

class GuideService extends Service
{
    public function __construct(Guide $guide)
    {
        parent::__construct($guide);
    }

    public function indexPageData($request)
    {

        try {
            $mansion_id = $request->query('mansion_id');

            $checkMansion_id = Mansion::findorFail($mansion_id);
            if ($checkMansion_id) {

                $mansion = Mansion::where('id', $mansion_id)->with('mansionGuide', 'contractor.contractorGuide')->get();

                return $mansion;
            }
        } catch (\Exception $e) {
            throw new ResourceNotFoundException(frontTrans('Mansion not found.'), 404);
        }
    }
}
