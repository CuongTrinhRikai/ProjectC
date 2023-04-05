<?php
namespace App\Services\System;

use App\Model\Config;
use App\Services\Service;
use App\Model\System\Guide;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Model\System\Mansion;
use App\Model\System\Contractor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MansionService extends Service
{
    public function __construct(Mansion $mansion,Contractor $contractor)
    {

        parent::__construct($mansion);
        $this->contractor = $contractor;
    }
    public function getAllData($data, $selectedColumns = [], $pagination = true)
    {
        $query = $this->query()->join('contractors', function ($join) use ($data) {
            $join->on('contractors.id', 'mansions.contractor_id')
                ->where('company_id', $data->company_id);
        });
        if (count($selectedColumns) > 0) {
            $query->select($selectedColumns);
        }
        if (isset($data->keyword) && $data->keyword !== null) {
            $query->whereRaw("LOWER(CONCAT_WS(' ',mansions.mansion_name,mansions.address,mansions.mansion_id)) LIKE LOWER('%" . addslashes((trim($data['keyword']))) . "%')");
            $query->orwhereHas('contractor', function ($query) use ($data) {
                $query->whereRaw(" LOWER(CONCAT_WS(' ', company_name)) LIKE LOWER('%" . addslashes((trim($data['keyword']))) . "%')");

            });

            $query->orwhereHas('mansionGuide', function ($query1) use ($data) {
                    $query1->whereRaw(" LOWER(CONCAT_WS(' ', name)) LIKE LOWER('%" . addslashes((trim($data['keyword']))) . "%')");
            });

        }
        $columns = [
            'mansions.id',
            'mansions.mansion_name',
            'mansions.address',
            'mansions.mansion_id',
            'mansions.contractor_id'
        ];
        if ($pagination) {
            return $query->with('mansionGuide')->orderBy('mansions.id', 'DESC')->select($columns)->paginate(25);
        } else {
            return $query->orderBy('mansions.id', 'DESC')->select($columns)->get();
        }
    }


    public function indexPageData($request)
    {
        return [
            'items' => $this->getAllData($request),
            'instructors' => $this->instructor(1, $request)
        ];
    }
    public function instructor($id, $request)
    {
         $instructors = Guide::where('contact_category_id',$id)->where('status', 1)
             ->whereHas('user', function ($query) use ($request) {
                 $query->where('company_id', $request->company_id);
             })->
        select(DB::raw("CONCAT(`name`,' (',`employee_number`,')') AS name"),'id')
        ->pluck('name','id')
        ->toArray();
        return $instructors;
    }

    public function createPageData($request)
    {
        return [
             'contractors' =>$this->getContractors($request),
             'instructor' => $this->instructor(1, $request),

        ];
    }

    // Data for edit page
    public function editPageData($request, $id)
    {

        $mansion = $this->itemByIdentifier($id);

        $selected = $mansion->mansionGuide()->pluck('instructor_id')->toArray();

        return [
            'item' => $this->itemByIdentifier($id),
            'selected' => $selected,
            'contractors' =>$this->getContractors($request),
            'instructor' => $this->instructor(1, $request),
        ];
    }
    public function getContractors($request)
    {
        $contractors = Contractor::
        select(DB::raw("CONCAT(`company_name`,' (',`contractorId`,')') AS company_name"), 'id')
            ->where('company_id', $request->company_id)
            ->pluck('company_name', 'id')
            ->toArray();
        return $contractors;
        // $mapped = array();
        // $contractors = $this->contractor->orderBy('id', 'ASC')->get();
        // foreach ($contractors as $contractor) {
        //     $mapped[$contractor->id] = $contractor->company_name;
        // }

        // return $mapped;
    }
    public function store($request)
    {

        $data = $request->except('_token','instructor_id');

        $data['created_by'] = Auth::user()->id;

        $mansion = $this->model->create($data);
        $instructorId = $request->instructor_id?? null;

        $mansion->mansionGuide()->attach($instructorId);
    }

    public function update($request, $id)
    {

        $data = $request->except('_token','instructor_id');
        $data['created_by'] = Auth::user()->id;
        $update = $this->itemByIdentifier($id);


        $update->fill($data)->save();
        $instructorId = $request->instructor_id ?? null;

        $update->mansionGuide()->sync($instructorId);
        $update = $this->itemByIdentifier($id);
        return $update;
    }



}
