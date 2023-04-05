<?php

namespace App\Services\Api;

use App\Services\Service;
use App\Model\System\Manual;
use App\Model\System\Mansion;
use App\Exceptions\ResourceNotFoundException;

class ManualService extends Service
{
    public function __construct(Manual $manual)
    {
        parent::__construct($manual);
    }

    public function indexPageData($request)
    {

        try {
            $buildingAdminMansionID = $request->user()->buildingAdminMansion->pluck('id')->toArray();
            $mansion_id = $request->query('mansion_id');

            $limit = $request->query('limit');
            $company_id = $request->company_id;
            if ($mansion_id) {
                $manual = Manual::where(function ($query) use ($mansion_id) {
                    $query->where('mansion_id', $mansion_id)
                        ->orWhereNull('mansion_id');
                })
                    ->where('flag', 1)
                    ->where('company_id', $company_id)
                    ->with('mansions')
                    ->orderBy('id', 'DESC')
                    ->paginate($limit ?? 25);

                return $manual;
            }
            $manual = Manual::where(function ($query) use ($buildingAdminMansionID) {
                $query->whereIn('mansion_id', $buildingAdminMansionID)
                    ->orWhereNull('mansion_id');
            })
                ->where('flag', 1)
                ->where('company_id', $company_id)
                ->with('mansions')
                ->orderBy('id', 'DESC')
                ->paginate($limit ?? 25);

            return $manual;
        } catch (\Exception $e) {
            throw new ResourceNotFoundException('Mansion not found.', 404);
        }
    }
}
