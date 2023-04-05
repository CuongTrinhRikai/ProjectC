<?php

namespace App\Services\System;

use App\Model\System\BuildingAdmin;
use App\Model\System\Contractor;
use App\Model\System\Mansion;
use App\Services\Service;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BuildingAdminService extends Service
{
    public function __construct(BuildingAdmin $buildingAdmin, Mansion $mansion, Contractor $contractor)
    {
        parent::__construct($buildingAdmin);
        $this->mansion = $mansion;
        $this->contractor = $contractor;
    }

    public function getMansions()
    {
        $mapped = array();

        $mansions = $this->mansion->orderBy('mansion_name', 'ASC')->whereHas('contractor', function ($query) {
            $query->where('company_id', \request()->company_id);
        })->get();
        foreach ($mansions as $mansion) {
            $mapped[$mansion->id] = $mansion->mansion_name;
        }
        return $mapped;
    }

    public function getContractor($request)
    {
        $contractors = Contractor::
        select(DB::raw("CONCAT(`company_name`,' (',`contractorId`,')') AS name"),'id')
            ->where('company_id', $request->company_id)
            ->pluck('name','id')
            ->toArray();
        return $contractors;
    }

    public function singleData($id){
        return $this->model->with('buildingAdminMansion')->find($id);
    }


    public function indexPageData($request)
    {
        return [
            'items' => $this->getAllData($request),
            'mansions' => $this->getMansions(),
            'contractors' => $this->getContractor($request),
            'business' => getBusinessCategory()
        ];
    }

    public function getAllData($data, $selectedColumns = [], $pagination = true)
    {
        $query = $this->query()
            ->join('contractors', function ($join) use ($data) {
                $join->on('contractors.id', 'building_admins.contractor_id')
                    ->where('company_id', $data->company_id);
            });
        if (count($selectedColumns) > 0) {
            $query->select($selectedColumns);
        }
        if (isset($data->keyword) && $data->keyword !== null) {
            $query->where('building_admins.name', 'LIKE', '%' . (addslashes($data->keyword)) . '%')
                ->orWhere('building_admins.username', 'LIKE', '%' . (addslashes($data->keyword)) . '%');
        }
        $columns = [
            'building_admins.id',
            'building_admins.name',
            'building_admins.username',
            'building_admins.business_category',
            'building_admins.contractor_id'
        ];

        if ($pagination) {
            return $query->orderBy('building_admins.id', 'DESC')->select($columns)->paginate(25);
        } else {
            return $query->select($columns)->get();
        }
    }

    public function createPageData($request)
    {
        return [
            'mansions' => $this->getMansions(),
            'contractors' => $this->getContractor($request),
            'business' => getBusinessCategory()
        ];
    }


    public function store($request)
    {
        \DB::transaction(function () use ($request) {
            $data = $request->except('_token');

            if ($request->password) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }
            $mansionIds = array_values($request->mansion_id);

            $buildingAdmin = $this->model->create($data);

            $buildingAdmin->buildingAdminMansion()->attach($mansionIds);

        });

    }

    public function editPageData($request, $id)
    {
        $buildingAdmin = $this->itemByIdentifier($id);

        $selectedmansion = $buildingAdmin->buildingAdminMansion()->get()->pluck('id');

        return [
            'item' => $buildingAdmin,
            'mansions' => $this->getMansions(),
            'contractors' => $this->getContractor($request),
            'business' => getBusinessCategory(),
            'selectedmansion' => $selectedmansion,
            'selectedbusiness' => $buildingAdmin->business_category
        ];
    }


    public function update($request, $id)
    {

        \DB::transaction(function () use ($request, $id) {

            $buildingAdmin = $this->model->findOrFail($id);

            $data = $request->except('_token');

            $mansionIds = array_values($request->mansion_id);

            $buildingAdmin->update($data);

            $buildingAdmin->buildingAdminMansion()->sync($mansionIds);
        });
    }


    public function resetPassword($request)
    {
        $buildingAdmin = $this->itemByIdentifier($request->id);
        return $buildingAdmin->update([
            'password' => Hash::make($request->password)
        ]);
    }


}
