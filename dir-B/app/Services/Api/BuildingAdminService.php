<?php
namespace App\Services\Api;

use App\Model\System\BuildingAdmin;
use App\Services\Service;
class BuildingAdminService extends Service
{
    public function __construct(BuildingAdmin $buildingAdmin)
    {
        parent::__construct($buildingAdmin);

    }

    public function singleData($id){
        return $this->model->with('buildingAdminMansion')->find($id);
    }

    public function update($request, $id)
    {
            $buildingAdmin = $this->model->findOrFail($id);

            $data = $request->except('_token');

            $buildingAdmin->update($data);
            return $buildingAdmin;

    }
}
