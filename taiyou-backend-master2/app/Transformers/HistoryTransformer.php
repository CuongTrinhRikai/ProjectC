<?php
namespace App\Transformers;
use App\Model\Category;
use App\Model\System\BuildingAdmin;
use App\Model\System\CheckInCheckOut;
use League\Fractal\TransformerAbstract;

class HistoryTransformer extends TransformerAbstract
{
    public function transform(CheckInCheckOut $checkInCheckOut)
    {
        $mansion = [];
        foreach ($checkInCheckOut->mansion as $keys => $mansions) {

            $mansion[$keys] ['id'] = $mansions->id ?? null;

        }
        return [

            'mansionName' => $mansion,


        ];
    }
}
