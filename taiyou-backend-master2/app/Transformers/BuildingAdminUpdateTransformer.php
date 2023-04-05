<?php
namespace App\Transformers;

use App\Model\System\BuildingAdmin;
use League\Fractal\TransformerAbstract;

class BuildingAdminUpdateTransformer extends TransformerAbstract
{
    public function transform(BuildingAdmin $buildingAdmin)
    {
        $mansionId = [];
        foreach ($buildingAdmin->buildingAdminMansion as $keys => $mansion) {

            $mansionId[$keys] ['id'] = $mansion->id ?? null;
            $mansionId[$keys] ['mansion_name'] = $mansion->mansion_name ?? null;
            $mansionId[$keys]['mansion_address'] = $mansion->address ?? null;
        }
        return [
            'buildingAdminName'=> $buildingAdmin->name,
            'buildingAdminUsername' => $buildingAdmin->username,
            'businessCategory' => $buildingAdmin->business_category,
            'homeAddress' => $buildingAdmin->home_address,
            'homePhoneNumber' => $buildingAdmin->home_phone_number,
            'mobileNumber' => $buildingAdmin->mobile_number,
            'contractorName' => $buildingAdmin->contractor->company_name ?? null,
            'mansionName' => $mansionId,

        ];
    }
}
