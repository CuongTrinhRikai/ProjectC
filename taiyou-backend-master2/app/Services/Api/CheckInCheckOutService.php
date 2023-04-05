<?php

namespace App\Services\Api;

use App\Http\Requests\Api\CheckInCheckOutRequest;
use App\Model\System\CheckInCheckOut;
use App\Model\System\Mansion;
use App\Services\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckInCheckOutService extends Service
{
    public function __construct(CheckInCheckOut $checkInCheckOut)
    {
        parent::__construct($checkInCheckOut);

    }

    public function getAll($request)
    {
        $mansion = $request['items'];
        return [
            'items' => $mansion->orderBy('id', 'ASC')->paginate(20)
        ];
    }

    public function getCheckIn($request)
    {
        $data['building_admin_id'] = \Auth::user()->id;
        $data['mansion_id'] = $request['mansion_id'];
        $data['latitude'] = $request['latitude'];
        $data['longitude'] = $request['longitude'];
        $data['check_in'] = Carbon::now()->format('Y-m-d H:i:s');
        $data['business_category'] = $request['businessCategory'];
        $checkInData = $this->model->create($data);
        return $checkInData;
    }


    public function update($request, $id)
    {
        $data = $request;
        $data['created_at'] = Carbon::parse($request['created_at'])->format('Y-m-d H:i:s');
        $data['updated_at'] = Carbon::parse($request['updated_at'])->format('Y-m-d H:i:s');

        CheckInCheckOut::where('id', $id)->update($data);
        return CheckInCheckOut::find($id);

    }
}
