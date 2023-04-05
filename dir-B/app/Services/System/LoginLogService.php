<?php

namespace App\Services\System;

use App\Model\Loginlogs;
use App\Services\Service;
use Carbon\Carbon;
use Config;

class LoginLogService extends Service
{
    public function __construct(Loginlogs $loginlogs)
    {
        parent::__construct($loginlogs);
    }

    public function getAllData($data, $selectedColumns = [], $pagination = true)
    {
        $query = $this->query()->whereHas('user', function($query) use ($data) {
            $query->where('company_id', $data->company_id);
        });
        if (count($selectedColumns) > 0) {
            $query->select($selectedColumns);
        }
        if (isset($data->from) && isset($data->to)) {
            $from = Carbon::createFromFormat('Y-m-d H:i:s', $data->from . ' 00:00:00');
            $to = Carbon::createFromFormat('Y-m-d H:i:s', $data->to . ' 23:59:00');
            $query->whereBetween('created_at', [$from, $to]);
        }
        if ($pagination) {
            return $query->orderBy('id', 'DESC')->with('user')->paginate(Config::get('constants.PAGINATION'));
        } else {
            return $query->get();
        }
    }

    public function indexPageData($data)
    {
        return [
            'items' => $this->getAllData($data)
        ];
    }
}
