<?php

namespace App\Transformers;

use App\Model\Category;
use App\Model\System\BuildingAdmin;
use League\Fractal\TransformerAbstract;

class BuildingAdminTransformer extends TransformerAbstract
{


    public function transform(BuildingAdmin $buildingAdmin)
    {

        $business = [
            '0'  => '管理員業務',
            '1'  => '日常清掃',
            '2'  => '管理委託',
            '3'  => '清掃管理業務',
            '4'  => '夜間管理業務',
            '5'  => '日常清掃及び設備管理要員',
            '6'  => 'コンシェル業務',
            '7'  => 'サブ管理員業務',
            '8'  => '日常清掃②',
            '9'  => '管理員業務②',
            '10'  => '終了清掃',
            '11'  => '管理員業務③',
            '12'  => '巡回清掃業務',
            '13'  => '巡回管理業務',
            '14'  => '夜間管理員',
            '15'  => '住み込み管理委託',
            '16'  => '日常清掃業務',
        ];


        $mansionId = [];
        foreach ($buildingAdmin->buildingAdminMansion as $keys => $mansion) {

            $mansionId[$keys]['id'] = $mansion->id ?? null;
            $mansionId[$keys]['mansionID'] = $mansion->mansion_id ?? null;
            $mansionId[$keys]['contractorId'] = $mansion->contractor->contractorId ?? null;
            $mansionId[$keys]['mansion_name'] = $mansion->mansion_name ?? null;
            $mansionId[$keys]['mansion_address'] = $mansion->address ?? null;
        }
        $businessCategory = [];

        foreach ($buildingAdmin->business_category as $value) {
            $businessCategory[] = $business[$value];
        }
        return [
            'buildingAdminID' => $buildingAdmin->id,
            'buildingAdminName' => $buildingAdmin->name,
            'buildingAdminUsername' => $buildingAdmin->username,
            'contractorName' => $buildingAdmin->contractor->company_name ?? null,
            'mansionName' => $mansionId,
            'companyName' => $buildingAdmin->contractor->company->name,
            'businessCategory' => implode(',', $businessCategory)
        ];
    }
}
