<?php

namespace App\Http\Controllers\Api\Notification;

use League\Fractal\Manager;
use Illuminate\Http\Request;
use App\Model\System\Notification;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiController;
use App\Transformers\NotificationTransformer;
use App\Model\System\NotificationBuildingAdmin;
use App\Http\Controllers\System\ResourceController;

class NotificationController extends ApiController
{
    public function __construct(Notification $notification)
    {
        parent::__construct(new Manager);
        $this->notification = $notification;
    }
    /**
     * @OA\Get (
     *     path = "/notifications",
     *     operationId = "Notification",
     *     tags = {"Notifications"},
     *     description="get notification list  ",
     *     security = {
     *      {"bearer_token":{}}
     *     },
     *     @OA\Response(
     *     response = "200",
     *     description = "Authorized",
     *     )
     * )
     */
    public function index(Request $request)
    {

        $userID = $request->user->id;
        $limit = $request->query('limit');
        try {
            $notification = Notification::where('company_id', $request->company_id)->where(function ($query) use ($userID){
                $query->whereHas('notificationbuildingAdmin', function ($item) use ($userID) {
                    return  $item->where('building_admin_id', $userID);
                })->orwhere('flag', 1);
            })->orderBy('id', 'DESC')->paginate($limit ?? 25);

            return $this->respondWithCollection($notification, new NotificationTransformer, 'notification');
        } catch (\Exception $e) {
            return $this->errorNotFound($e->getMessage());
        }
    }
}
