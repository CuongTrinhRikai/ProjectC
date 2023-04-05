<?php

namespace App\Services\System;


use Config;
use GuzzleHttp\Client;
use App\Services\Service;
use Illuminate\Http\Request;
use App\Model\System\Contractor;
use App\Model\System\Notification;
use Illuminate\Support\Facades\DB;
use App\Model\System\BuildingAdmin;
use App\Exceptions\CustomGenericException;
use Exception;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Expr\AssignOp\Concat;
use PhpParser\Node\Stmt\Catch_;

class NotificationService extends Service
{
    public function __construct(Notification $notification, BuildingAdmin $buildingAdmin)
    {

        parent::__construct($notification);

        $this->buildingAdmin = $buildingAdmin;
    }

    public function getContractor($request)
    {

        $contractors = Contractor::
        select(DB::raw("CONCAT(`company_name`,' (',`contractorId`,')') AS company_name"), 'id')
            ->where('company_id', $request->company_id)
            ->pluck('company_name', 'id')
            ->toArray();

        return $contractors;
    }

    public function getbuildingAdmin($request)
    {
        $buildingAdmin = BuildingAdmin::
        select(DB::raw("CONCAT(`name`,' (',`username`,')') AS name"), 'id')
            ->whereHas('contractor', function ($query) use ($request) {
                $query->where('company_id', $request->company_id);
            })
            ->pluck('name', 'id')
            ->toArray();
        return $buildingAdmin;
    }

    public function getAllData($data, $selectedColumns = [], $pagination = true)
    {
        $query = $this->query()->where('company_id', $data->company_id);
        if (count($selectedColumns) > 0) {
            $query->select($selectedColumns);
        }
//        if(strlen($data->keyword) < 100 ){
        if (isset($data->keyword) && $data->keyword !== null) {
            $query->whereRaw(" LOWER(CONCAT_WS(' ', title,body,name_of_registrant)) LIKE LOWER('%" . addslashes(trim($data['keyword'])) . "%')");
        }
//        }
        if (isset($data->group) && $data->group == 0) {
            $query->where('flag', $data->group);
        }
        if (isset($data->group) && $data->group == 1) {
            $query->where('flag', $data->group);
        }
        if ($pagination) {
            return $query->orderBy('id', 'DESC')->paginate(\Config::get('constants.PAGINATION'));
        } else {
            return $query->orderBy('id', 'DESC')->get();
        }
    }

    public function indexPageData($request)
    {
        return [
            'items' => $this->getAllData($request),
            'flagSearch' => $this->searchByFlag()

        ];
    }

    public function createPageData($request)
    {
        return [
            'contractors' => $this->getContractor($request),
            'buildingAdmins' => $this->getbuildingAdmin($request),
            'flag' => $this->flag(),
        ];
    }

    public function editPageData($request, $id)
    {
        $notification = $this->itemByIdentifier($id);

        $admin = $notification->notificationbuildingAdmin()->pluck('building_admin_id')->toArray();
        $contractor = $notification->notificationcontractor()->pluck('contractor_id')->toArray();
        return [
            'item' => $this->itemByIdentifier($id),
            'contractors' => $this->getContractor($request),
            'buildingAdmins' => $this->getbuildingAdmin($request),
            'flag' => $this->flag(),
            'selected' => $admin,
            'contractor' => $contractor
        ];
    }

    public function flag()
    {
        return [
            ['value' => 0, 'label' => 'Private'],
            ['value' => 1, 'label' => 'Public']
        ];
    }

    public function store($request)
    {
        try {
            DB::transaction(function () use ($request) {
                $contractor = $request->contractor_id;
                $admin = $request->building_admin_id;
                $data = $request->except('_token', 'contractor_id', 'building_admin_id');

                if ($request->flag == 0) {

                    $checkContractor = Notification::getContractorFromBuildingAdmin($contractor)->toArray();
                    $admin = array_unique(array_merge($checkContractor ?? [], $admin ?? []));
                    $notification = $this->sanitizecreateModel($request, $data,$admin);
                    if (count($admin) > 0 && $admin != null) {
                        $client = new Client(['base_uri' => Config::get('constants.FCM_TO_USERS')]);
                        $res = $client->request('POST', '', [
                            'json' => [
                                'ids' => $admin,
                                'title' => $data['title'],
                                'body' => $data['body'],
                                'type' => env('TYPE'),
                                'clickAction' => env('CLICKACTION'),
                                'value' => env('VALUE'),
                                'token' => env('TOKEN'),
                                'domain' => env('DOMAIN'),
                                'notificationId' => $notification->id,
                                'senderName' => $notification->name_of_registrant,
                                'notificationDateTime' => $notification->created_at->format('Y-m-d H:i:s'),
                            ]
                        ]);


                        if (200 == $res->getStatusCode()) {

                            DB::commit();
                        } else {
                            DB::rollback();
                            throw new CustomGenericException(translate('Unsuccessful to send notification'));
                        }
                    } else {
                        DB::rollback();

                        throw new CustomGenericException(translate('Unsuccessful to send notification'));
                    }
                } else {
                    $admin = Notification::getBuildingAdminFromCompany($request->company_id)->toArray();
                    $data = $request->except('_token', 'contractor_id', 'building_admin_id');
                    $request->contractor_id = null;
                    $request->building_admin_id = null;
                    $notification = $this->sanitizecreateModel($request, $data, null);

                    $client = new Client(['base_uri' => Config::get('constants.FCM_TO_USERS')]);
                    $res = $client->request('POST', '', [
                        'json' => [
                            'ids' => $admin,
                            'title' => $data['title'],
                            'body' => $data['body'],
                            'type' => env('TYPE'),
                            'clickAction' => env('CLICKACTION'),
                            'value' => env('VALUE'),
                            'token' => env('TOKEN'),
                            'domain' => env('DOMAIN'),
                            'notificationId' => $notification->id,
                            'senderName' => $notification->name_of_registrant,
                            'notificationDateTime' => $notification->created_at->format('Y-m-d H:i:s'),
                        ]
                    ]);

                    if (200 == $res->getStatusCode()) {
                        DB::commit();
                    } else {
                        DB::rollback();
                        throw new CustomGenericException(translate('Unsuccessful to send notification'));
                    }
                }
            });
        } catch (\Exception $e) {
            DB::rollback();
            throw new CustomGenericException(translate('Unsuccessful to send notification'));
        }
    }

    public function delete($request, $id)
    {
        try{
            DB::transaction(function () use ($request,$id) {
                $item = $this->itemByIdentifier($id);
                $item->notificationbuildingAdmin()->detach($id);
                $item->notificationcontractor()->detach($id);
                return $item->delete();
                DB::commit();
            });
        }catch(Exception $e){
            throw new CustomGenericException(translate('Delete Unsuccessfull'));
            DB::rollback();

        }
    }

    public function sanitizecreateModel(Request $request, $data,$admin)
    {
        $notification =  $this->model->create($data);
        if (isset($request->contractor_id)) {
            $contractorid = array_values($request->contractor_id);
            $notification->notificationcontractor()->attach($contractorid);
        }
        if (isset($admin)) {
            $adminIds = array_values($admin);
            $notification->notificationbuildingAdmin()->attach($adminIds);
        }
        return $notification;
    }

    public function getbuildingAdminByContractor($id)
    {
        return BuildingAdmin::where('contractor_id', $id)->get();
    }
    public  function searchByFlag()
    {
        return array(
            '0'  => translate('Private'),
            '1'  => translate('Public'),
        );
    }
}
