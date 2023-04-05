<?php

namespace App\Services\System;

use App\User;
use App\Services\Service;
use App\Model\System\Guide;
use Illuminate\Support\Str;
use App\Model\System\Mansion;
use App\Model\System\Contractor;
use App\Model\System\ContractorGuide;
use App\Model\System\MansionGuide;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GuideService extends Service
{
    public function __construct(Guide $guide, Mansion $mansion)
    {
        parent::__construct($guide);
    }

    public function getStatus()
    {
        return array([
            'value' => '1',
            'label' => 'Active'
        ],
            [
                'value' => '0',
                'label' => 'Inactive'
            ]);
    }

    public function getAllData($data, $selectedColumns = [], $pagination = true)
    {

        $query = $this->query()
            ->whereHas('user', function ($query) use ($data){
            $query->where('company_id', $data->company_id);
        });
        if (count($selectedColumns) > 0) {
            $query->select($selectedColumns);
        }
        if (isset($data->keyword) && $data->keyword !== null) {
            $query->whereRaw("LOWER(CONCAT_WS(' ',employee_number,line_id,name,mobile_number,email)) LIKE LOWER('%" . addslashes(trim($data['keyword'])) . "%')");
        }
        if (isset($data->group) && $data->group !== null) {
            $query->where('contact_category_id', $data->group);
        }
        if (isset($data->group) && $data->group == 0) {
            $query->where('contact_category_id', $data->group);
        }
        if (isset($data->group) && $data->group == 1) {
            $query->where('contact_category_id', $data->group);
        }
        if (isset($data->group) && $data->group == 2) {
            $query->where('contact_category_id', $data->group);
        }
        if (isset($data->group) && $data->group == 3) {
            $query->where('contact_category_id', $data->group);
        }

        if ($pagination) {
            return $query->orderBy('id', 'DESC')->paginate(25);
        } else {
            return $query->orderBy('id', 'DESC')->get();
        }
    }
    public function indexPageData($request)
    {
        return [
            'items' => $this->getAllData($request),
            'contact' => $this->getContactCategory(),
        ];
    }

    public function createPageData($request)
    {
        return [
            'contact' => $this->getContactCategory(),
            'status' => $this->getStatus(),
        ];
    }

    public  function getContactCategory()
    {

        return array(

            '0'  => translate('Sales Staff'),
            '1'  => translate('The Instructor'),
            '2'  => translate('Sales Affair'),
            '3'  => translate('Company General Affairs'),
        );
    }


    public function store($request)
    {

        $data = $request->except('_token');

        $data['user_id'] = Auth::user()->id;

        if ($request->password) {
            $data['password'] = Hash::make($data['password']);
        }
        if ($data['contact_category_id'] == 1) {
            $data['email'] = null;
        }
        if ($data['contact_category_id'] == 2 || $data['contact_category_id'] == 3) {
            $data['line_id'] = null;
        }

        $guide  = $this->model->create($data);
    }

    public function editPageData($request, $id)
    {

        return [
            'item' => $this->itemByIdentifier($id),
            'contact' => $this->getContactCategory(),
            'status' => $this->getStatus(),

        ];
    }

    public function update($request, $id)
    {
        // $mansionIds = $request->mansion_id;
        $data = $request->except('_token');

        $guide = $this->itemByIdentifier($id);
        if ($request->contact_category_id != $guide->contact_category_id) {
        $this->updateContractorGuide($id);
        }
        if ($request->contact_category_id != $guide->contact_category_id) {
        $this->updateMansionGuide($id);
        }
        if ($data['contact_category_id'] == 1) {
            $data['email'] = null;
        }

        if ($data['contact_category_id'] == 2 || $data['contact_category_id'] == 3) {
            $data['line_id'] = null;
        }

        $guide->update($data);
    }
    public function updateContractorGuide($id){
        ContractorGuide::where('guide_id',$id)->delete();

    }
    public function updateMansionGuide($id){
        MansionGuide::where('instructor_id',$id)->delete();

    }

}
