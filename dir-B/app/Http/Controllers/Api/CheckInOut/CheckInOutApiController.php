<?php

namespace App\Http\Controllers\Api\CheckInOut;

use App\Model\Company;
use App\Model\System\BuildingAdmin;
use App\Model\System\BuildingAdminMansion;
use App\Model\System\Contractor;
use App\Model\System\Mansion;
use DateTime;
use Carbon\Carbon;
use App\Events\Checkin;

use Illuminate\Support\Facades\Log;
use Lcobucci\JWT\Parser;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\System\CheckInCheckOut;
use App\Services\System\MansionService;
use App\Transformers\HistoryTransformer;
//use Dotenv\Parser\Parser;
use App\Http\Controllers\Api\ApiController;
use App\Transformers\CheckInOutTransformer;
use App\Services\Api\CheckInCheckOutService;
use App\Transformers\CheckInCheckOutTransformer;
use App\Http\Requests\Api\CheckInCheckOutRequest;

class CheckInOutApiController extends ApiController
{
    /**
     * CheckInOutApiController constructor.
     * @param CheckInCheckOutService $checkInCheckOutService
     */
    public function __construct(CheckInCheckOutService $checkInCheckOutService, MansionService $mansionService)
    {
        $this->service = $checkInCheckOutService;
        $this->mansionService = $mansionService;

        parent::__construct(new Manager);
    }
    const formatDate = 'Y-m-d H:i:s';
    const formatYMD = 'Y-m-d';
    const timezone = 'Asia/Tokyo';

    /**
     * @OA\Post(
     *     path="/check-in",
     *     operationId="check-in",
     *     tags={"CheckIn CheckOut"},
     *     summary="CheckIn",
     *     description="check-in using access token",
     *     security = {
     *      {"bearer_token":{}}
     *     },
     *     @OA\RequestBody(
     *             @OA\JsonContent(
     *                 required={"mansion_id", "contractorId", "longitude","latitude","businessCategory"},
     *                 @OA\Property(
     *                     property="mansion_id",
     *                     type="integer",
     *                     default="Enter Mansion Id",
     *                 ),
     *                  @OA\Property(
     *                     property="contractorId",
     *                     type="integer",
     *                     default="Enter Contractor Id",
     *                 ),
     *                 @OA\Property(
     *                     property="Longitude",
     *                     type="integer",
     *                     default="Enter Longitude"
     *                 ),
     *                 @OA\Property(
     *                     property="Latitude",
     *                     type="integer",
     *                     default="Enter Latitude",
     *                 ),
     *                  @OA\Property(
     *                     property="businessCategory",
     *                     type="string",
     *                     default="Enter Business Category",
     *                 ),
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Authorized",
     *     ),
     * )
     */

    public function postCheckIn(Request $request)
    {
        Log::info('Request from mobile ' . json_encode($request->all()) . '--Class : ' . __CLASS__ . ' --Function : ' . __FUNCTION__);
        //building list of user with related mansion and contractor
        $buildingIds = BuildingAdminMansion::where('building_admin_id', $request->user()->id)
            ->with('mansion')->get()->map(function ($item){
                $item->mansion_id_name = $item->mansion->mansion_id;
                $item->contractorId = $item->mansion->contractor->contractorId;
                if(preg_match('~[0-9]+~', $item->contractorId)){
                    $item->contractorId = preg_replace( '/\D/', '', $item->contractorId);
                }
                elseif(!ctype_alnum($item->contractorId) && !ctype_alpha($item->contractorId)) {
                    $item->contractorId = $item->contractorId;
                }
                elseif(ctype_alpha($item->contractorId)) {
                    $item->contractorId = $item->contractorId;
                }
                else{
                    $item->contractorId = preg_replace( '/\D/', '', $item->contractorId);
                }
                $item->contractorId = json_encode($item->contractorId);
                return $item;
            });

        if(preg_match('~[0-9]+~', $request->contractorId)){
            $contractor = preg_replace( '/\D/', '', $request->contractorId);
        }
        elseif(!ctype_alnum($request->contractorId) && !ctype_alpha($request->contractorId)) {
            $contractor = $request->contractorId;
        }
        elseif(ctype_alpha($request->contractorId)) {
            $contractor = $request->contractorId;
        }
        else{
            $contractor = preg_replace( '/\D/', '', $request->contractorId);
        }
        $contractor = json_encode($contractor);

        $user = $buildingIds->where('mansion_id_name', $request->mansion_id)->where('contractorId', $contractor)->first();

        $mansionList = Mansion::where('mansion_id', '=', $request->mansion_id)->first();

        if ($request->mansion_id === null) {
            return $this->errorNotFound( frontTrans('このマンションはアサインされていません。'));
        }
        if ($request->contractorId === null) {
            return $this->errorNotFound( frontTrans('この業者はアサインされていません。'));
        }
        if($mansionList === null)
        {
            return $this->errorNotFound( frontTrans('このマンションはシステム上に見つかりません。'));
        }

        if($user)
        {
            $request->merge(['mansion_id' => $user->mansion_id]);
        }

        if ($request->latitude === null) {
            return $this->errorNotFound( frontTrans('緯度が必要です。'));
        }
        if ($request->longitude === null) {
            return $this->errorNotFound( frontTrans('経度が必要です。'));
        }
        if ($user === null) {
            return $this->errorNotFound(frontTrans('このマンションが現在の物件にアサインされません。'));
        }
        else {
            // Get business category from building admin when QR code without business category
            $changeBusinessCategory = false;
            if (!isset($request['businessCategory']) || is_null($request['businessCategory'])) {
                $dataBusinessCategory = $request->user()->business_category;
                $request->merge([
                    'businessCategory' => Business($dataBusinessCategory[0])
                ]);
                $changeBusinessCategory = true;
            }

            $startTime = Carbon::parse(now(), 'Asia/Tokyo')->addHour(9)->startOfDay()->format('Y-m-d H:i:s');
            $endTime = Carbon::parse(now(), 'Asia/Tokyo')->addHour(9)->endOfDay()->format('Y-m-d H:i:s');

            $samebuilding = CheckInCheckOut::whereRaw("convert_tz(check_in,'+00:00','+09:00') >= '".$startTime."'")
                ->whereRaw("convert_tz(check_in,'+00:00','+09:00') <= '".$endTime."'")
                ->where('building_admin_id', $request->user()->id)
                ->where('mansion_id', '!=', $request->mansion_id)
                ->orderBy('check_in', 'DESC')
                ->first();
            if ($samebuilding != null) {
                $issamebuilding = CheckInCheckOut::whereRaw("convert_tz(check_in,'+00:00','+09:00') >= '".$startTime."'")
                    ->whereRaw("convert_tz(check_in,'+00:00','+09:00') <= '".$endTime."'")
                    ->where('building_admin_id', $request->user()->id)
                    ->where('mansion_id', $request->mansion_id)
                    ->where('business_category', $request->businessCategory)
                    ->orderBy('check_in', 'DESC')
                    ->first();

                if ($issamebuilding != null) {
                    return $this->errorForbidden(frontTrans('同日付に複数の時点でチェックインできません'));
                } else {
                    if ($samebuilding->check_out == null) {
                        $samebuilding->check_out = null;
                        $object = json_decode(json_encode($samebuilding), true);
                        $this->service->update($object, $samebuilding->id);
                    }
                    $checkInCheckOut = $this->service->getCheckIn($request);
                    $emailCompany = Company::where('id', $request->company_id)->first();
                    $emailReceiveMail = $emailCompany->email;
                    event(new Checkin($checkInCheckOut, $emailReceiveMail, $checkInCheckOut->business_category));
                    if ($request->has('businessCategory')) {
                        if ($this->businessCategory($request->businessCategory) && !$changeBusinessCategory){
                            return $this->responseOkWithFlag(frontTrans('Checked In Successfully!!!'));
                        }
                        return $this->responseOkWithFlagValue(frontTrans('Checked In Successfully!!!'), frontTrans('太陽ビルの管理者に「06-6392-3980」で連絡してください。'));
                    } else {
                        return $this->responseOk(frontTrans('Checked In Successfully!!!'));
                    }
                }


            } else {
                $issamebuilding =
                    CheckInCheckOut::whereRaw("convert_tz(check_in,'+00:00','+09:00') >= '" . $startTime . "'")
                        ->whereRaw("convert_tz(check_in,'+00:00','+09:00') <= '" . $endTime . "'")
                        ->where('building_admin_id', $request->user()->id)
                        ->where('mansion_id', $request->mansion_id)
                        ->where('business_category', $request->businessCategory)
                        ->first();

                if ($issamebuilding != null) {
                    return $this->errorForbidden(frontTrans('同日付に複数の時点でチェックインできません'));
                } else {
                    $checkintime = CheckInCheckOut::whereRaw("convert_tz(check_in,'+00:00','+09:00') >= '".$startTime."'")
                        ->whereRaw("convert_tz(check_in,'+00:00','+09:00') <= '".$endTime."'")
                        ->where('mansion_id', $request->mansion_id)
                        ->where('building_admin_id', $request->user()->id)
                        ->where('business_category', $request->businessCategory)
                        ->first();
                    if ($checkintime == null) {
                        $checkInCheckOut = $this->service->getCheckIn($request);
                        $emailCompany = Company::where('id', $request->company_id)->first();
                        $emailReceiveMail = $emailCompany->email;
                        event(new Checkin($checkInCheckOut, $emailReceiveMail, $checkInCheckOut->business_category));
                        if ($request->has('businessCategory')) {
                            if ($this->businessCategory($request->businessCategory) && !$changeBusinessCategory){
                                return $this->responseOkWithFlag(frontTrans('Checked In Successfully!!!'));
                            }
                            return $this->responseOkWithFlagValue(frontTrans('Checked In Successfully!!!'), frontTrans('太陽ビルの管理者に「06-6392-3980」で連絡してください。'));
                        } else {
                            return $this->responseOk(frontTrans('Checked In Successfully!!!'));
                        }
                    }
                }

            }

        }

    }

    public function businessCategory($businessCategory)
    {

        $requestBusiness = json_encode($businessCategory);
        $availableBusiness = json_encode(businessCategory($businessCategory));
        if($businessCategory != null && $requestBusiness == $availableBusiness){
            return true;
        }

    }
    /**
     * @OA\Post (
     *     path = "/check-out",
     *     operationId = "check-out",
     *     tags = {"CheckIn CheckOut"},
     *     summary = "CheckOut",
     *     description="check-out using access token",
     *     security = {
     *      {"bearer_token":{}}
     *     },
     *     @OA\RequestBody(
     *             @OA\JsonContent(
     *                 required={"mansionId", "contractorId", "Longitude","Latitude"},
     *                 @OA\Property(
     *                     property="mansionId",
     *                     type="integer",
     *                     default="Enter Mansion Id",
     *                 ),
     *                 @OA\Property(
     *                     property="contractorId",
     *                     type="integer",
     *                     default="Enter Contractor Id",
     *                 ),
     *                 @OA\Property(
     *                     property="Longitude",
     *                     type="integer",
     *                     default="Enter Longitude"
     *                 ),
     *                 @OA\Property(
     *                     property="Latitude",
     *                     type="integer",
     *                     default="Enter Latitude",
     *                 ),
     *         )
     *     ),
     *     @OA\Response(
     *     response = "200",
     *     description = "Authorized",
     *     )
     * )
     */

    public function postCheckOut(Request $request)
    {
        Log::info('Request from mobile ' . json_encode($request->all()) . '--Class : ' . __CLASS__ . ' --Function : ' . __FUNCTION__);
        $buildingIds = BuildingAdminMansion::where('building_admin_id', $request->user()->id)->with('mansion')->get()->map(function ($item){
            $item->mansion_id_name = $item->mansion->mansion_id;
            $item->contractorId = $item->mansion->contractor->contractorId;

            if(preg_match('~[0-9]+~', $item->contractorId)){
                $item->contractorId = preg_replace( '/\D/', '', $item->contractorId);
            }
            elseif(!ctype_alnum($item->contractorId) && !ctype_alpha($item->contractorId)) {
                $item->contractorId = $item->contractorId;
            }
            elseif(ctype_alpha($item->contractorId)) {
                $item->contractorId = $item->contractorId;
            }
            else{
                $item->contractorId = preg_replace( '/\D/', '', $item->contractorId);
            }
            $item->contractorId = json_encode($item->contractorId);
            return $item;
        });

        if(preg_match('~[0-9]+~', $request->contractorId)){
            $contractor = preg_replace( '/\D/', '', $request->contractorId);
        }
        elseif(!ctype_alnum($request->contractorId) && !ctype_alpha($request->contractorId)) {
            $contractor = $request->contractorId;
        }
        elseif(ctype_alpha($request->contractorId)) {
            $contractor = $request->contractorId;
        }
        else{
            $contractor = preg_replace( '/\D/', '', $request->contractorId);
        }
        $contractor = json_encode($contractor);

        $user = $buildingIds->where('mansion_id_name', '=', $request->mansion_id)->where('contractorId', $contractor)->first();

        $mansionList = Mansion::where('mansion_id', '=', $request->mansion_id)->first();
        if ($request->mansion_id === null) {
            return $this->errorNotFound( frontTrans('このマンションはアサインされていません。'));
        }
        if ($request->contractorId === null) {
            return $this->errorNotFound( frontTrans('この業者はアサインされていません。'));
        }
        if($mansionList === null)
        {
            return $this->errorNotFound( frontTrans('このマンションはシステム上に見つかりません。'));
        }
        if($user) {
            $request->merge(['mansion_id' => $user->mansion_id]);
        }

        if ($request->latitude === null) {
            return $this->errorNotFound(frontTrans('緯度が必要です。'));
        }
        if ($request->longitude === null) {
            return $this->errorNotFound(frontTrans('経度が必要です。'));
        }
        if ($user === null) {
            return $this->errorNotFound(frontTrans('このマンションが現在の物件にアサインされません。'));
        }

        $checkoutTime = Carbon::now()->setTimezone(self::timezone)->format(self::formatDate);

        $queryLastCheckin  = CheckInCheckOut::where('building_admin_id', $request->user()->id)
            ->where('mansion_id', $request->mansion_id)
            ->whereNull('check_out');
        if (!$request->has('businessCategory') || is_null($request->businessCategory)) {
            $listBusinessCategory = Auth::user()->business_category;
            $request->merge([
                'businessCategory'=>Business($listBusinessCategory[0])
            ]);
        }
        if (isset($request->version_app) && version_compare($request->version_app, \Config::get('constants.VERSION_APP'), '>=')) {
            $queryLastCheckin->where('business_category', $request->businessCategory);
        }
        $lastCheckin = $queryLastCheckin->orderBy('check_in', 'DESC')
            ->first();
        if ($lastCheckin == null) {
            return $this->errorForbidden(frontTrans('先にチェックインしてください。'));
        }
        $latestCheckinTime = Carbon::parse($lastCheckin->check_in, 'Asia/Tokyo')->addHour(9);
        $validLatestCheckoutTime = Carbon::parse($lastCheckin->check_in, 'Asia/Tokyo')->addHour(9)->startOfDay()->addDay(1)->addHour(3)->addMinute(59)->addSecond(59);

        $startTime = Carbon::parse($lastCheckin->check_in, 'Asia/Tokyo')->startOfDay();

        $queryCheckinDetail = CheckInCheckOut::where('building_admin_id', $request->user()->id)
            ->where('mansion_id', $request->mansion_id)
            ->whereNull('check_out');
        $queryChecklatest = CheckInCheckOut::where('check_in', '>=', Carbon::parse($startTime)->format('Y-m-d H:i:s'))
            ->where('check_in', '<=', Carbon::parse($validLatestCheckoutTime)->format('Y-m-d H:i:s'))
            ->where('mansion_id', $request->mansion_id)
            ->where('building_admin_id', $request->user()->id)
            ->whereNull('check_out');

        if (isset($request->version_app) && version_compare($request->version_app, \Config::get('constants.VERSION_APP'), '>=')){
            $queryCheckinDetail->where('business_category', $request->businessCategory);
            $queryChecklatest->where('business_category', $request->businessCategory);
        }

        $checkinDetail = $queryCheckinDetail->where('check_in', '>=', Carbon::parse($startTime)->format('Y-m-d H:i:s'))
            ->where('check_in', '<=', Carbon::parse($validLatestCheckoutTime)->format('Y-m-d H:i:s'))
            ->first();
        $checklatest = $queryChecklatest->orderBy('check_in', 'DESC')
            ->first();
        if ($checkinDetail == null) {
            return $this->errorForbidden(frontTrans('先にチェックインしてください。'));
        }
        if ($checklatest->mansion_id != $request->mansion_id) {
            return $this->errorForbidden(frontTrans('チェックアウトできません。'));
        }
        if ($checklatest->check_out != null) {
            return $this->responseOk(frontTrans('Already Checkout from this Mansion.'));
        }
        if ($latestCheckinTime < $checkoutTime && $checkoutTime < $validLatestCheckoutTime) {
            $lastCheckin->check_out = Carbon::now()->format('Y-m-d H:i:s');
            $object = json_decode(json_encode($lastCheckin), true);
            $this->service->update($object, $lastCheckin->id);
            //event(new Checkin($checkInCheckOut));
            return $this->responseOk(frontTrans('Checked Out Successfully.!!!'));
        } else {
            return $this->errorForbidden(frontTrans('Please reload this page and check-in first.'));

        }
    }

    /**
     * @OA\Get (
     *     path = "/check-in-check-out-detail",
     *     operationId = "check-in-check-out-detail",
     *     tags = {"CheckIn CheckOut"},
     *     summary = "CheckIn CheckOut History",
     *     security = {
     *      {"bearer_token":{}}
     *     },
     *       @OA\Parameter(
     *              required={"input_date"},
     *               name="input_date",
     *                  in="query",
     *                  required=true,
     *                  ),
     *       @OA\Parameter(
     *               name="id",
     *                  in="query",
     *                  ),
     *     @OA\Response(
     *     response = "200",
     *     description = "Authorized",
     *     )
     * )
     */
    public function detail(Request $request)
    {
        $Date = $request->query('input_date');
        if ($Date == "" || $Date == null) {
            return $this->errorForbidden(frontTrans("日付を入力してください。"));
        }
        $validDate = date(self::formatYMD, strtotime($Date));

        if ($Date != $validDate) {
            return $this->errorForbidden(frontTrans("有効な日付を入力してください。"));
        }
        $requestedDate =$validDate;
        $requestedMansionId = $request->query('id');


        $m = strtotime($requestedDate);
        $today = date('l', $m);
        $custom_date = strtotime(date('d-m-Y', $m));
        if ($today == 'Monday') {
            $week_start = date(self::formatYMD, $m);
        } else {
            $week_start = date(self::formatYMD, strtotime('this week last monday', $custom_date));
        }

        if ($today == 'Sunday') {
            $week_end = date(self::formatYMD, $m);
        } else {
            $week_end = date(self::formatYMD, strtotime('this week next sunday', $custom_date));
        }
        $week_end = date(self::formatYMD, strtotime($week_end . ' +1 day'));

        $test = collect();
        $countday = $week_start;
        $count = 0;
        do {
            $nextday = date('Y-m-d', strtotime("+1 day", strtotime($countday)));
            if ($requestedMansionId == null || $requestedMansionId == "") {
                $details = CheckInCheckOut::where('building_admin_id', $request->user()->id)
                    ->where('check_in', '>=', date('Y-m-d H:i:s', strtotime('-9 hours', strtotime($countday))))
                    ->where('check_in', '<', date('Y-m-d H:i:s', strtotime('-9 hours', strtotime($nextday))))
                    ->get();
            } else {
                $details = CheckInCheckOut::where('building_admin_id', $request->user()->id)
                    ->where('check_in', '>=', date('Y-m-d H:i:s', strtotime('-9 hours', strtotime($countday))))
                    ->where('check_in', '<', date('Y-m-d H:i:s', strtotime('-9 hours', strtotime($nextday))))
                    ->where('mansion_id', $requestedMansionId)
                    ->get();

            }

            if (count($details) == 0) {
                $mansion = null;

                $dayDate = date(self::formatYMD, strtotime($countday));
                $check = $test->where('dayDate', $dayDate)->first();
                $temp['dayDate'] = $dayDate;
                $temp['day'] = date('l', strtotime($countday));

                if ($check != null) {
                    foreach ($test as $key => $value)
                        if ($value['dayDate'] == $check['dayDate'])
                            $test->forget($key);
                    $temp['mansion'] = $check['mansion'];
                    $temp['mansion'][count($check['mansion'])] = $mansion;
                } else {
                    $temp['mansion'][0] = $mansion;

                }
                $test->push($temp);

                $temp = [];

            } else {
                foreach ($details as $detail) {
                    $mansion = [
                        "Id" => $detail->id,
                        "mansionId" => $detail->mansion->mansion_id,
                        "contractorId" => $detail->mansion->contractor->contractorId,
                        "mansionName" => $detail->mansion->mansion_name,
                        "mansionAddress" => $detail->mansion->address,
                        "checkInTime" =>$detail->check_in == null ? $detail->check_in : japaneseDateTime($detail->check_in)->format('Y-m-d H:i:s'), //yyyy-MM-dd
                        "checkOutTime" =>$detail->check_out == null ? $detail->check_out : japaneseDateTime($detail->check_out)->format('Y-m-d H:i:s'), //yyyy-MM-dd
                        "latitude" => $detail->latitude,
                        "longitude" => $detail->longitude,
                        "businessCategory" => $detail->business_category
                    ];


                    $dayDate = date(self::formatYMD, strtotime($countday));

                    $check = $test->where('dayDate', $dayDate)->first();
                    $temp['dayDate'] = $dayDate;
                    $temp['day'] = date('l', strtotime($countday));

                    if ($check != null) {
                        foreach ($test as $key => $value)
                            if ($value['dayDate'] == $check['dayDate'])
                                $test->forget($key);
                        $temp['mansion'] = $check['mansion'];
                        $temp['mansion'][count($check['mansion'])] = $mansion;
                    } else {
                        $temp['mansion'][0] = $mansion;

                    }
                    $test->push($temp);

                    $temp = [];
                }
            }
            $countday = date(self::formatYMD, strtotime("+1 day", strtotime($countday)));
            $count++;

        } while ($count != 7);

        return response()->json(['data' => $test->sortBy('dayDate')->values()]);

    }

    /**
     * @OA\Get (
     *     path = "/user-check-out",
     *     operationId = "user-check-out",
     *     tags = {"CheckIn CheckOut"},
     *     summary = "Has User Checkout",
     *     security = {
     *      {"bearer_token":{}}
     *     },
     *       @OA\Parameter(
     *              required={"input_date"},
     *               name="input_date",
     *                  in="query",
     *                  required=true,
     *                  ),
     *     @OA\Response(
     *     response = "200",
     *     description = "Authorized",
     *     )
     * )
     */
    public function message(Request $request)
    {
        $users = $request->user()->id;

        $todayDate = $request->query('input_date');
        if ($todayDate == "" || $todayDate == null) {
            return $this->errorForbidden(frontTrans("日付を入力してください。"));
        }
        $validDate = date(self::formatYMD, strtotime($todayDate));
        if ($todayDate != $validDate) {
            return $this->errorForbidden(frontTrans("有効な日付を入力してください。"));
        }

        $getAttendanceRecord = function ($date) use($users){
            return CheckInCheckOut::
            whereRaw("DATE_FORMAT(DATE(convert_tz(check_in,'+00:00','+09:00')),'%Y-%m-%d')='".$date."'")
                ->where('building_admin_id', $users)
                ->orderBy('check_in', 'DESC')->get();
        };

        $attendance = $getAttendanceRecord($todayDate);
        $previousDate = Carbon::parse($todayDate, 'UTC')->subDay(1)->format('Y-m-d');

        $previousAttendance = $getAttendanceRecord($previousDate);
        if($attendance->toArray() == null && $previousAttendance->toArray() != null){
            $dataAttendance = [];
            $time = null;
            foreach ($previousAttendance as $value) {
                $allowedCheckOutTime = Carbon::parse($value->check_in, 'Asia/Tokyo')->addHour(9)->addDay(1)->startOfDay()->addHour(4)->subSecond(1);
                if ($value->check_in != null && $value->check_out == null) {
                    $now = Carbon::now()->setTimezone(self::timezone)->format(self::formatDate);
                    if ($allowedCheckOutTime >= $now) {
                        $dataAttendance[] = $value;
                        $time = $getAttendanceRecord(Carbon::parse($value->check_in, 'Asia/Tokyo')->addHour(9)->subDay(1)->format('Y-m-d'));
                    }
                }
            }
            if ($dataAttendance){
                $attendance = $dataAttendance;
            }

            if($time){
                $previousAttendance = CheckInCheckOut::
                whereRaw("DATE_FORMAT(DATE(check_in),'%Y-%m-%d')='".$time."'")
                    ->where('building_admin_id', $users)
                    ->orderBy('check_in', 'DESC')
                    ->get();
            }
        }
        return $this->attendanceResponse($attendance,$previousAttendance, $request);
    }

    public function attendanceResponse($attendance, $previousAttendance, $request)
    {
        $hasCheckInToday = false;
        $attendanceData = null;
        if ($attendance){
            $timeDate = null;
            foreach ($attendance as $value){
                if (isset($value) && !is_null($value->check_in) && !is_null($value->check_out)){
                    $hasCheckInToday = false;
                    $timeDate = Carbon::parse($value->check_in, 'Asia/Tokyo')->format(self::formatYMD);
                } else{
                    $timeDate = Carbon::parse($value->check_in, 'Asia/Tokyo')->format(self::formatYMD);
                    $hasCheckInToday = true;
                    break;
                }
            }
            $attendanceData = CheckInCheckOut::
            whereRaw("DATE_FORMAT(DATE(check_in),'%Y-%m-%d')='".$timeDate."'")
                ->where('building_admin_id', $request->user()->id)
                ->distinct('mansion_id')
                ->whereNull('check_out')
                ->orderBy('check_in', 'DESC')
                ->first();
        }

//        $hasCheckInToday = false;
//        $attendanceData = null;
//        if ($attendance) {
//            $timeDate = null;
//            foreach ($attendance as $value) {
//                if (isset($value) && !is_null($value->check_in) && !is_null($value->check_out)) {
//                    $hasCheckInToday = false;
//                    $timeDate = Carbon::parse($value->check_in, 'Asia/Tokyo')->format(self::formatYMD);
//                } else {
//                    $timeDate = Carbon::parse($value->check_in, 'Asia/Tokyo')->format(self::formatYMD);
//                    $hasCheckInToday = true;
//                    break;
//                }
//            }
//        }
        $checkInPreviousDay = [];
        $checkOutPreviousDay = [];
        $message = [];
        $success = '';
        $statusSuccess = 0;
        $forgot = '';
        $statusForgot = 0;
        $neither = '';
        $statusNeither = 0;
        if ($previousAttendance) {
            foreach ($previousAttendance as $value) {
                $yesterdayCheckIn = $value->check_in ?? null;
                $yesterdayCheckout = $value->check_out ?? null;
                if (!!$yesterdayCheckIn && !!$yesterdayCheckout) {
                    $success = $this->getMessage($success, $value);
                    $statusSuccess = 1;
                }

                if (!!$yesterdayCheckIn && !$yesterdayCheckout) {
                    $forgot = $this->getMessage($forgot, $value);
                    $statusForgot = 2;
                }

                if (!$yesterdayCheckIn && !$yesterdayCheckout) {
                    $neither = $this->getMessage($neither, $value);
                    $statusNeither = 3;
                }
                $checkInPreviousDay[] = $value->check_in;
                $checkOutPreviousDay[] = $value->check_out;
            }
        }

        $responseData['data'] = [
                'hasCheckInPreviousDay' => ($checkInPreviousDay != null && !in_array(null, $checkInPreviousDay)) ? true : false,
                'hasCheckedOutPreviousDay' => ($checkOutPreviousDay != null && !in_array(null, $checkOutPreviousDay)) ? true : false,
                'hasCheckInToday' => $hasCheckInToday,
                'message' => $this->attendanceMessage($success, $statusSuccess, $forgot, $statusForgot, $neither, $statusNeither, $message, $request)
            ] + $this->getMansionData($attendanceData);
        return response()->json($responseData);
    }

    public function getMessage($message, $value)
    {
        if ($message == null) {
            $name =  array_key_exists('', getNameFromCode()) ? getNameFromCode()[$value->business_category] : '';
            $message = '業務カテゴリー:' . $name . '(' . $value->mansion->mansion_name . ')';

        } else {
            $name =  array_key_exists($value->business_category, getNameFromCode()) ? getNameFromCode()[$value->business_category] : '';
            $message .= '、' . $name . '(' . $value->mansion->mansion_name . ')';
        }

        return $message;
    }

    public function getMansionData($attendance){
        if(!$attendance){
            return [
                'mansionId' => null,
                'mansionName' => null
            ];
        }
        return [
            'mansionId' => $attendance->mansion_id,
            'mansionName' => $attendance->mansion->mansion_name
        ];
    }

    public function attendanceMessage($success, $statusSuccess, $forgot, $statusForgot,  $neither, $statusNeither, $message, $request)
    {
        if (!!$success && $statusSuccess == 1) {
            $message[] = $success . ' ' . "物件管理者が前日にチェックアウトしました。";
        }

        if (!!$forgot && $statusForgot == 2) {
            $message[] = $forgot . ' ' . "昨日のチェックアウトを忘れました。";
        }

        if (!!$neither && $statusNeither == 3) {
            $message[] = $neither . ' ' . "昨日はチェックインもチェックアウトもしていません。";
        }

        if (isset($request->version_app) && version_compare($request->version_app, \Config::get('constants.VERSION_APP'), '>=')) {
            return $message;
        }
        if ($message) {
            return $message[0];
        }

        return '';
        
    }
}
