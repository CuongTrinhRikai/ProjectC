<?php

namespace App\Services;

use App\Exceptions\ResourceNotFoundException;
use Config;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Service
{
    /**
     * Stores the model used for service
     * @var Eloquent object
     */
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    // get all data

    public function getAllData($data, $selectedColumns = [], $pagination = true)
    {
        $query = $this->query();
        if (count($selectedColumns) > 0) {
            $query->select($selectedColumns);
        }
        if (isset($data->keyword) && $data->keyword !== null) {
            $query->where('name', 'LIKE', '%' . $data->keyword . '%');
        }
        if ($pagination) {
            return $query->orderBy('id', 'DESC')->paginate(Config::get('constants.PAGINATION'));
        } else {
            return $query->orderBy('id', 'DESC')->get();
        }
    }

    // find model by its identifier

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function findByEmail($email)
    {
        $data = $this->model->where('email', $email)->first();
        if (!isset($data)) {
            throw new ModelNotFoundException;
        }
        return $data;
    }

    //store single record

    public function store($request)
    {
        return $this->model->create($request->except('_token'));
    }

    // store bulk records

    public function storeBulk($data)
    {
        return $this->model->createMany($data);
    }

    //update record

    public function update($request, $id)
    {
        $data = $request->except('_token');
        $update = $this->itemByIdentifier($id);
        $update->fill($data)->save();
        $update = $this->itemByIdentifier($id);
        return $update;
    }

    //delete a record

    public function delete($request, $id)
    {
        $item = $this->itemByIdentifier($id);
        return $item->delete();
    }

    //Get intem by its identifier

    public function itemByIdentifier($id)
    {
        try {
            return $this->model->findOrFail($id);
        } catch (\Exception $e) {
            throw new ResourceNotFoundException();
        }
    }

    // Data for index page

    public function indexPageData($request)
    {
        return [
            'items' => $this->getAllData($request)
        ];
    }

    // Data for create page

    public function createPageData($request)
    {
        return [
            'status' => $this->status()
        ];
    }

    // Data for edit page
    public function editPageData($request, $id)
    {
        return [
            'item' => $this->itemByIdentifier($id),
            'status' => $this->status()
        ];
    }

    // get query for modal

    public function query()
    {
        return $this->model->query();
    }

    public function status()
    {
        return [
            ['value' => 1, 'label' => 'Active'],
            ['value' => 0, 'label' => 'Inactive']
        ];
    }
}
