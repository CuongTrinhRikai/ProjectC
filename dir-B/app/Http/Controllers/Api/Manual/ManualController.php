<?php

namespace App\Http\Controllers\Api\Manual;

use League\Fractal\Manager;
use Illuminate\Http\Request;
use App\Services\Api\ManualService;
use App\Http\Controllers\Controller;
use App\Transformers\ManualTransformer;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\ApiController;

class ManualController extends ApiController
{
    public function __construct(ManualService $manualService)
    {

        $this->service = $manualService;
        parent::__construct(new Manager);
    }

    public function index(Request $request)
    {

        try {
            // if ($request->query('mansion_id') == null || $request->query('mansion_id') == '') {
            //     return $this->errorNotFound(frontTrans('Please input the mansion id.'));
            // }

            $manual = $this->service->indexPageData($request);

            return $this->respondWithCollection($manual, new ManualTransformer, 'manual');
        } catch (\Exception $e) {
            return $this->errorNotFound($e->getMessage());
        }
    }


}
