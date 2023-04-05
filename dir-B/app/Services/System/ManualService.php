<?php

namespace App\Services\System;

use App\Model\Config;
use App\Services\Service;
use App\Model\System\Manual;
use App\Model\System\Mansion;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use function PHPUnit\Framework\isEmpty;

class ManualService extends Service
{
    public function __construct(Manual $manual, Mansion $mansion)
    {
        parent::__construct($manual);
        $this->mansion = $mansion;
    }

    public function getAllData($data, $selectedColumns = [], $pagination = true)
    {
        $query = $this->query()->where('company_id', $data->company_id);
        if (count($selectedColumns) > 0) {
            $query->select($selectedColumns);
        }
        if (isset($data->keyword) && $data->keyword !== null) {
            $query->whereRaw("LOWER(CONCAT_WS(' ',name,manual_id)) LIKE LOWER('%" . addslashes(trim($data['keyword'])) . "%')");
            $query->orwhereHas('mansions', function ($query) use ($data) {
                $query->whereRaw(" LOWER(CONCAT_WS(' ', mansion_name)) LIKE LOWER('%" . addslashes(trim($data['keyword'])) . "%')");
            });
        }
        if (isset($data->group) && $data->group !== null) {
            $query->where('manual_type', $data->group);
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
            'mansions' => $this->getMansions($request),
            'sortBY' => $this->videoBy(),
        ];
    }

    public function createPageData($request)
    {
        return [
            'mansions' => $this->getMansions($request),
            'status' => $this->status(),
            'manualtype' => $this->ManualType(),

        ];
    }

    // Data for edit page
    public function editPageData($request, $id)
    {
        return [
            'item' => $this->itemByIdentifier($id),
            'status' => $this->status(),
            'mansions' => $this->getMansions($request),
            'manualtype' => $this->ManualType(),

        ];
    }

    public function getMansions($request)
    {
        $mapped = array();
        $mansions = $this->mansion->whereHas('contractor', function ($query) use ($request){
            $query->where('company_id', $request->company_id);
        })->orderBy('id', 'ASC')->get();

        foreach ($mansions as $mansion) {
            $mapped[$mansion->id] = $mansion->mansion_name;
        }

        return $mapped;
    }

    public function store($request)
    {


        $data = $request->except('_token');

        $data['filename'] = $request->original_name;

        if ($data['manual_type'] == 1) {

            // $upload = Storage::disk('s3')->put('pdf',  $request->url);
            $data['url'] = $request->file_name;
        } else {
            // $upload = Storage::disk('s3')->put('video',  $request->url);
            $data['url'] = $request->file_name;
        }

        return $this->model->create($data);
    }

    public function update($request, $id)
    {
        $data = $request->except('_token');

        $data['filename'] = $request->original_name ?? $request->old_filename;
        $data['url'] = $request->file_name ?? $request->old_url;

        $update = $this->itemByIdentifier($id);

        $update->fill($data)->save();


        return $update;
    }

    public function delete($request, $id)
    {

        $item = $this->itemByIdentifier($id);
        Storage::disk('s3')->delete($item->url);
        return $item->delete();
    }

    public function ManualType()
    {
        return [
            ['value' => 1, 'label' => 'Pdf'],
            ['value' => 0, 'label' => 'Video']
        ];
    }

    public function videoBy()
    {
        return [
            '0' => translate('video'),
            '1' => translate('pdf'),
        ];
    }

    public function validateUnique($col, $value, $id)
    {
        $query = $this->query();
        if ($id) {
            $query->where('id', '!=', $id);
        }
        $result =   $query->where($col, $value)->get();
        if ($result->isEmpty()) {
            return true;
        }
        return false;
    }
}
