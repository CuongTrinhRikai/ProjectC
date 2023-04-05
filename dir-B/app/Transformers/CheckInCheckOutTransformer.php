<?php
namespace App\Transformers;

use App\Model\System\CheckInCheckOut;
use League\Fractal\TransformerAbstract;

class CheckInCheckOutTransformer extends TransformerAbstract
{
    public function transform()
    {
        return [
            'checkInOutPreviousDay' => true,
		    'hasCheckedOut' => true,
		    'message' => 'Building admin has checked out the previous day.'
        ];
    }
}
