<?php

namespace App\Http\Controllers\Api\buildingAdmin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\BuildingAdminRequest;
use \App\Services\Api\BuildingAdminService;
use App\Transformers\BuildingAdminTransformer;
use App\Transformers\BuildingAdminUpdateTransformer;
use Illuminate\Http\Request;
use League\Fractal\Manager;


class BuildingAdminApiController extends ApiController
{
    public function __construct(BuildingAdminService $buildingAdminService)
    {
        $this->service = $buildingAdminService;
        parent::__construct(new Manager);
    }

    /**
     * @OA\Get (
     *     path = "/building-admin",
     *     operationId = "Building Admin Profile",
     *     tags = {"Building Admin"},
     *     summary = "Building Admin Profile",
     *     security = {
     *      {"bearer_token":{}}
     *     },
     *     @OA\Response(
     *     response = "200",
     *     description = "Authorized",
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $buildingAdminId = $request->user()->id;
        $buildingAdmin = $this->service->singleData($buildingAdminId);
        return $this->respondWithItem($buildingAdmin, new BuildingAdminTransformer, 'buildingAdmin');
    }

}
