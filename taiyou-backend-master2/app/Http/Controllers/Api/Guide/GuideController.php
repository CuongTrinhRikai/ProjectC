<?php

namespace App\Http\Controllers\Api\Guide;

use App\Model\System\Guide;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use App\Model\System\Mansion;
use App\Services\Api\GuideService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Transformers\GuideTransformer;
use App\Http\Requests\Api\GuideRequest;
use App\Http\Controllers\Api\ApiController;

class GuideController extends ApiController
{
    public function __construct(GuideService $guideService)
    {

        $this->service = $guideService;
        parent::__construct(new Manager);
    }

    /**
     * @OA\Get (
     *     path = "/guides",
     *     operationId = "Guide",
     *     tags = {"Guides"},
     *     summary = "filter guides",
     *     security = {
     *      {"bearer_token":{}}
     *     },
     * @OA\Parameter(
     *  required={"mansion_id"},
     *  name="mansion_id",
     * in="query",
     * description="get guide list  using mansion  id",
     * required=true,
     *           ),
     *     @OA\Response(
     *     response = "200",
     *     description = "Authorized",
     *     )
     * )
     */
    public function index(Request $request)
    {
        try {
            if ($request->query('mansion_id') == null || $request->query('mansion_id') == '') {
                return $this->errorNotFound(frontTrans('Please input the mansion id.'));
            }


            $guide = $this->service->indexPageData($request);

            $result =  $this->transform($guide[0]);
            return response()->json($result);
        } catch (\Exception $e) {

            return $this->errorNotFound($e->getMessage());
        }
    }
    public function transform($mansion)
    {

        $mansionInstructorArray = [];
        $saleStaffArray = [];
        $salesaffairArray = [];
        $companygeneralaffairsArray = [];
        foreach ($mansion->mansionGuide as $keys => $instructor) {

            $mansionInstructorArray[$keys]['name'] = $instructor->name ?? null;
            $mansionInstructorArray[$keys]['line_id'] = $instructor->line_id ?? null;
            $mansionInstructorArray[$keys]['email'] = $instructor->email ?? null;
            $mansionInstructorArray[$keys]['mobile_number'] = $instructor->mobile_number ?? null;
            $mansionInstructorArray[$keys]['type'] = 'instructor';
        }




        foreach ($mansion->contractor->contractorGuide as $k => $guide) {
            if ($guide->contact_category_id == 0) {

                $saleStaffArray[$k]['name'] = $guide->name ?? null;
                $saleStaffArray[$k]['line_id'] = $guide->line_id ?? null;
                $saleStaffArray[$k]['email'] = $guide->email ?? null;
                $saleStaffArray[$k]['mobile_number'] = $guide->mobile_number ?? null;
                $saleStaffArray[$k]['type'] = 'sales_staff';
            };
            if ($guide->contact_category_id == 2) {
                $salesaffairArray[$k]['name'] = $guide->name ?? null;
                $salesaffairArray[$k]['line_id'] = $guide->line_id ?? null;
                $salesaffairArray[$k]['email'] = $guide->email ?? null;
                $salesaffairArray[$k]['mobile_number'] = $guide->mobile_number ?? null;
                $salesaffairArray[$k]['type'] = 'sales_affair';
            };
            if ($guide->contact_category_id == 3) {
                $companygeneralaffairsArray[$k]['name'] = $guide->name ?? null;
                $companygeneralaffairsArray[$k]['line_id'] = $guide->line_id ?? null;
                $companygeneralaffairsArray[$k]['email'] = $guide->email ?? null;
                $companygeneralaffairsArray[$k]['mobile_number'] = $guide->mobile_number ?? null;
                $companygeneralaffairsArray[$k]['type'] = 'company_general_affairs';
            };
        }


        $guideListArray = array_merge($mansionInstructorArray, $saleStaffArray, $salesaffairArray, $companygeneralaffairsArray);
        $paginateValues =  paginateCollection($guideListArray, 5);
        $onlyValues =  paginateCollection($guideListArray, 5)->values();

        $total = $paginateValues->total();
        $count = $paginateValues->count();
        $per_page = $paginateValues->perPage();
        $current_page = $paginateValues->currentPage();
        $total_pages = $paginateValues->lastPage();
        $nextPage = $paginateValues->nextPageUrl();
        $previousPage = $paginateValues->previousPageUrl();

        $paginationData['pagination'] = [
            'total' => $total,
            'per_page' => $per_page,
            'count' => $count,
            'current_page' => $current_page,
            'total_pages' => $total_pages,
            'links' => [
                'next' => $nextPage,
                'previous' => $previousPage,
            ]
        ];
        $meta = \Config::get('constants.META');
        $paginationData = array_merge($meta['meta'], $paginationData);
        $finalData['meta'] = $paginationData;
        $finalData['data'] = [

            'mansion' => [
                'mansion_id' => $mansion->mansion_id ?? null,
                'name' => $mansion->mansion_name ?? null,
                'address' => $mansion->address ?? null,
                'phone_number' => $mansion->mansion_phone ?? null,

            ],
            'contractor' => [
                'name' => $mansion->contractor->company_name ?? null,

            ],
            'guides_list' => $onlyValues
        ];
        return $finalData;
    }
}
