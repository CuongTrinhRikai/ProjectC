<?php

namespace App\Transformers;

use App\Model\System\Guide;
use App\Model\System\Mansion;
use Illuminate\Http\Request;
use League\Fractal\TransformerAbstract;

use function GuzzleHttp\json_decode;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class GuideTransformer extends TransformerAbstract
{
    // public function __construct($data)
    // {
    //     $this->data = $data;
    // }
    public function transform(Mansion $mansion)
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


        $paginateValues =  paginateCollection($guideListArray,5);
        $onlyValues =  paginateCollection($guideListArray,5)->values();

       $total =$paginateValues->total();
       $count = $paginateValues->count();
       $per_page = $paginateValues->perPage();
       $current_page = $paginateValues->currentPage();
       $total_pages = $paginateValues->lastPage();
       $nextPage = $paginateValues->nextPageUrl();
       $previousPage = $paginateValues->previousPageUrl();
       $paginationData=[
        'total' =>$total,
        'per_page' =>$per_page,
        'count'=>$count,
        'current_page' =>$current_page,
        'total_pages' =>$total_pages,
        'links' =>[
            'next' =>$nextPage,
            'previous' =>$previousPage,
        ]
    ];



        // $test =  collect($guideListArray);
        // $skip = 5 * ($this->page - 1);
        // $guideList = $test->skip($skip)->take(5);
        // $list = $guideList->toArray();

        return [
            $paginationData,
            'mansion' => [
                'mansion_id' => $mansion->mansion_id ?? null,
                'name' => $mansion->mansion_name ?? null,
                'address' => $mansion->address ?? null,

            ],
            'contractor' => [
                'name' => $mansion->contractor->company_name ?? null,

            ],
            'guides_list' => $onlyValues
        ];
    }
}
