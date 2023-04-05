<?php

namespace App\Services\System;

use App\Model\System\BuildingAdmin;
use App\Model\System\CheckInCheckOut;
use App\Model\System\Contractor;
use App\Model\System\Mansion;
use App\Services\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class InformationService extends Service
{
    public function __construct(CheckInCheckOut $checkInCheckOut, Mansion $mansion, BuildingAdmin $buildingAdmin, Contractor $contractor)
    {
        parent::__construct($checkInCheckOut);
        $this->mansion = $mansion;
        $this->buildingAdmin = $buildingAdmin;
        $this->contractor = $contractor;
    }

    public function allInfo($data, $selectedColumns = [], $pagination = true)
    {
        $query = $this->query()
            ->whereHas('buildingAdmin', function ($query) use ($data) {
                $query->whereHas('contractor', function ($query) use ($data) {
                    $query->where('company_id', $data->company_id);
                });
            });
        if (count($selectedColumns) > 0) {

            $query->select($selectedColumns);
        }

        if (isset($data['keyword'])&& $data['keyword'] != "") {
            $query->where(function ($q) use($data) {
                $q->whereHas('buildingAdmin', function ($info) use ($data) {
                    $info->whereRaw(" LOWER(CONCAT_WS(' ', username)) LIKE LOWER('%" . (trim(addslashes($data['keyword']))) . "%')");

                })->orwhereHas('mansion', function ($info) use ($data) {
                    $info->whereRaw(" LOWER(CONCAT_WS(' ', mansion_name)) LIKE LOWER('%" . (trim(addslashes($data['keyword']))) . "%')");
                });
            });
        }

        if (isset($data->from) && isset($data->to) && $data->from != "" && $data->to != "") {
            $from = Carbon::createFromFormat('Y-m-d H:i:s', $data->from . ' 00:00:00');
            $to = Carbon::createFromFormat('Y-m-d H:i:s', $data->to . ' 23:59:00');
            $query->whereRaw("convert_tz(check_in,'+00:00','+09:00') >= '".$from."'")
                ->whereRaw("convert_tz(check_in,'+00:00','+09:00') <= '".$to."'");
        }

        if (isset($data['mansion_name']) && $data['mansion_name'] != "")  {

            $query->where('mansion_id', $data['mansion_name']);
        }

        if (isset($data['building_id']) && $data['building_id'] != "")  {

            $query->where('building_admin_id', $data['building_id']);
        }

        if (isset($data['contractor_name']) && $data['contractor_name'] != "")  {

            $query->whereHas('mansion.contractor',function($q) use ($data){
                $q->whereId($data['contractor_name']);
            });

        }

        if ($pagination && \Request::route()->uri == 'system/info-display') {
            return $query->with(['mansion','mansion.contractor','buildingAdmin'])->orderBy('id', 'DESC')->paginate(25);
        } else {
            return $query->with(['mansion','mansion.contractor','buildingAdmin'])->get();
        }
    }

    public function getMansions($request)
    {
        $mansions = $this->mansion->whereHas('contractor', function ($query) use ($request){
            $query->where('company_id', $request->company_id);
        })->get();

        return $mansions;
    }

    public function getBuildings($request)
    {
        $buildings = $this->buildingAdmin->whereHas('contractor', function ($query) use ($request){
            $query->where('company_id', $request->company_id);
        })->get();

        return $buildings;
    }

    public function getContractors($request)
    {
        return $this->contractor->where('company_id', $request->company_id)->get();

    }

    public function indexPageData($request)
    {
        return [
            'items' => $this->allInfo($request),
            'mansions' => $this->getMansions($request),
            'buildings' => $this->getBuildings($request),
            'contractors' => $this->getContractors($request),
        ];
    }

    public function editPageData($request, $id)
    {
        $info = $this->itemByIdentifier($id);

        return [
            'item' => $info,
        ];
    }


    public function update($request, $id)
    {
        \DB::transaction(function () use ($request, $id) {

            $info = $this->model->findOrFail($id);

            if($request->check_out == null || $request->check_out == 'N/A')
            {
                $request['check_out'] =  $request->check_out;

            }
            else
            {
                $check_out = carbon::parse($request->check_out)->subHours(9)->format('Y-m-d H:i:s');
                $request['check_out'] = $check_out;
            }

            $request['check_in'] = carbon::parse($request->check_in)->subHours(9)->format('Y-m-d H:i:s');
            $data = $request->except('_token','mansion_name','building_admin_id','contractor_name','latitude','longitude');

            $info->update($data);

        });
    }
}
