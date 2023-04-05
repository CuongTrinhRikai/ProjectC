<?php

namespace App\Services\System;

use App\Model\Config;
use App\Services\Service;
use App\Model\System\Guide;
use App\Model\System\Contractor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ContractorService extends Service
{
    public function __construct(Contractor $contractor)
    {
        parent::__construct($contractor);
    }

    public function indexPageData($request)
    {
        return [
            'items' => $this->getAllData($request)
        ];
    }

    public function getAllData($data, $selectedColumns = [], $pagination = true)
    {
        $query = $this->query()->where('company_id', $data->company_id);
        if (count($selectedColumns) > 0) {
            $query->select($selectedColumns);
        }


        if (isset($data->keyword) && $data->keyword !== null) {
            $query->whereRaw("LOWER(CONCAT_WS(' ',company_name,contractorId)) LIKE LOWER('%" . (addslashes(trim($data['keyword']))) . "%')");

            $query->orwhereHas('contractorGuide', function ($query1) use ($data) {
                $query1->whereRaw(" LOWER(CONCAT_WS(' ', name)) LIKE LOWER('%" . (addslashes(trim($data['keyword']))) . "%')");
        });
        }
        if ($pagination) {
            return $query->with('contractorGuide')->orderBy('id', 'DESC')->paginate(25);
        } else {
            return $query->with('contractorGuide')->orderBy('id', 'DESC')->get();
        }
    }

    public function store($request)
    {
        $data = $request->except('_token');
        $data['created_by'] = Auth::user()->id;

        $contractor = $this->model->create($data);
        $sales_staff = $request->sales_staff ?? null;
        $sales_affair = $request->sales_affair ?? null;
        $company_general_affair = $request->company_general_affair ?? null;
        if (isset($sales_staff) && $sales_staff != null) {

            $contractor->contractorGuide()->attach($sales_staff, [
                'type' => '0'
            ]);
        }
        if (isset($sales_affair) && $sales_affair != null) {

            $contractor->contractorGuide()->attach($sales_affair, [
                'type' => '2'
            ]);
        }
        if (isset($company_general_affair) && $company_general_affair != null) {

            $contractor->contractorGuide()->attach($company_general_affair, [
                'type' => '3'
            ]);
        }
    }
    public function update($request,$id)
    {

        $data = $request->except('_token');
        $data['created_by'] = Auth::user()->id;
        $contractor = $this->itemByIdentifier($id);
        $contractor->fill($data)->save();
        $sales_staff = $request->sales_staff;

        $sales_affair = $request->sales_affair;
        $company_general_affair = $request->company_general_affair;
        $contractor->contractorGuide()->detach();
        if (isset($sales_staff) && $sales_staff != null) {

            $contractor->contractorGuide()->attach($sales_staff, [
                'type' => '0'
            ]);
        }
        if (isset($sales_affair) && $sales_affair != null) {

            $contractor->contractorGuide()->attach($sales_affair, [
                'type' => '2'
            ]);
        }
        if (isset($company_general_affair) && $company_general_affair != null) {

            $contractor->contractorGuide()->attach($company_general_affair, [
                'type' => '3'
            ]);
        }
    }



    public function guideCategory($id, $request)
    {
        return  Guide::where('contact_category_id',$id)->where('status', 1)
            ->whereHas('user', function ($query) use ($request) {
                $query->where('company_id', $request->company_id);
            })->
        select(DB::raw("CONCAT(`name`,' (',`employee_number`,')') AS name"),'id')
        ->pluck('name','id')
        ->toArray();
        // return Guide::where('contact_category_id', $id)->pluck('name', 'id');
    }

    public function createPageData($request)
    {
        return [
            'status' => $this->status(),
            'sales_staff' => $this->guideCategory(0, $request),
            'sales_affair' => $this->guideCategory(2, $request),
            'company_general_affair' => $this->guideCategory(3, $request)

        ];
    }

    public function editPageData($request, $id)
    {
        $contractor = $this->itemByIdentifier($id);
         $selected = $contractor->contractorGuide()->pluck('guide_id')->toArray();

        return [
            'item' => $this->itemByIdentifier($id),
            'sales_staff' => $this->guideCategory(0, $request),
            'sales_affair' => $this->guideCategory(2, $request),
            'company_general_affair' => $this->guideCategory(3, $request),
            'selected'=>$selected
        ];
    }
}
