<?php

use App\Model\Config as conf;
use App\Model\Language;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

function authUser()
{
    return Auth::user();
}

function setRoleCache($user)
{
    return \Cache::put('role-' . $user->id, $user->role);
}

function getRoleCache($user)
{
    // return \Cache::get('role-'.$user->id);
    return $user->role;
}

function clearRoleCache($user)
{
    return \Cache::forget('role-' . $user->id);
}

function frontendUser()
{
    return Auth::guard('frontendUsers')->user();
}

function getCmsConfig($label)
{
    if ($label == "cms title") {
        $con = 'title';
    } elseif ($label == "cms logo") {
        $con = 'logo';
    } elseif ($label == "cms theme color") {
        $con = 'color';
    }

    if (request()->company_id == null) {
        $value = Cookie::get($con);;
    } else {
        $data = conf::where('label', $label)->where('company_id', request()->company_id)->first()->value;
        $value = $data;
    }
    return $value;
}

function generateToken($length)
{
    return bin2hex(openssl_random_pseudo_bytes($length));
}

function showInSideBar($check)
{
    return $check;
}

function modules()
{
    $modules = Config::get('cmsConfig.modules');
    return $modules;
}

function configTypes()
{
    return ['file', 'text', 'textarea', 'number'];
}

function getCountries()
{
    $http = new Client();
    $response = $http->get('https://restcountries.eu/rest/v2/all');
    $countries = (\GuzzleHttp\json_decode($response->getBody()->getContents()));
    return transformCountries($countries);
}

function transformCountries($countries)
{
    $transformedCountries = [];
    foreach ($countries as $key => $value) {
        $transformedCountries[$key]['name'] = $value->name;
        $transformedCountries[$key]['alpha_code'] = $value->alpha2Code;
        $transformedCountries[$key]['alpha_code_3'] = $value->alpha3Code;
        $transformedCountries[$key]['native_name'] = $value->nativeName;
        $transformedCountries[$key]['alternate_spellings'] = json_encode($value->altSpellings, JSON_UNESCAPED_SLASHES);
        $transformedCountries[$key]['calling_codes'] = json_encode($value->callingCodes, JSON_UNESCAPED_SLASHES);
        $transformedCountries[$key]['currencies'] = json_encode($value->currencies, JSON_UNESCAPED_SLASHES);
        $transformedCountries[$key]['languages'] = json_encode($value->languages, JSON_UNESCAPED_SLASHES);
        $transformedCountries[$key]['flag'] = $value->flag;
    }
    return $transformedCountries;
}

function globalLanguages()
{
    $languages = Language::where('group', 'backend')->get();
    return $languages;
}

function setConfigCookie($company_id = null)
{
    $defaultTitle = 'TAIYOU';
    $defaultLogo = 'cms_logo.png';
    $defaultColor = '#292961';
    if (is_null($company_id)) {
        Cookie::queue('title', $defaultTitle, 10000);
        Cookie::queue('logo', $defaultLogo, 10000);
        Cookie::queue('color', $defaultColor, 10000);
    } else {
        Cookie::queue('title', conf::where('label', 'cms title')->where('company_id', $company_id)->first()->value,
            10000);
        Cookie::queue('logo', conf::where('label', 'cms logo')->where('company_id', $company_id)->first()->value,
            10000);
        Cookie::queue('color',
            conf::where('label', 'cms theme color')->where('company_id', $company_id)->first()->value, 10000);
    }
}

function localDatetime($dateTime)
{
    return Carbon::parse($dateTime)->timezone('Asia/Kathmandu');
}

function utcDatetime($dateTime)
{
    return Carbon::parse($dateTime)->timezone('UTC');
}

function japaneseDateTime($dateTime)
{
    return Carbon::parse($dateTime)->timezone('Asia/Tokyo');
}

function storeLog($performedOn, $msg)
{
    $now = Carbon::now()->format('Y-m-d H:i:s');
    activity()
        ->performedOn($performedOn)
        ->log($msg . ' at ' . $now);
}

function logMessage($modelName, $modelId, $eventName)
{
    $user = authUser()->name ?? '--';
    $now = Carbon::now()->format('Y-m-d H:i:s');
    return "$modelName of id {$modelId} was <strong>{$eventName}</strong> by {$user} at {$now}.";
}

function pageIndex($items)
{
    $sn = 0;
    if (method_exists($items, 'perPage') && method_exists($items, 'currentPage')) {
        $sn = $items->perPage() * ($items->currentPage() - 1);
    }
    return $sn;
}

function SN($sn, $key)
{
    return $sn += $key + 1;
}

function randomPassword($length = 6, $add_dashes = false, $available_sets = 'luds')
{
    $sets = array();
    if (strpos($available_sets, 'l') !== false) {
        $sets[] = 'abcdefghjkmnpqrstuvwxyz';
    }
    if (strpos($available_sets, 'u') !== false) {
        $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
    }
    if (strpos($available_sets, 'd') !== false) {
        $sets[] = '23456789';
    }
    if (strpos($available_sets, 's') !== false) {
        $sets[] = '!@#$%&*?';
    }
    $all = '';
    $password = '';
    foreach ($sets as $set) {
        $password .= $set[array_rand(str_split($set))];
        $all .= $set;
    }
    $all = str_split($all);
    for ($i = 0; $i < $length - count($sets); $i++) {
        $password .= $all[array_rand($all)];
    }
    $password = str_shuffle($password);
    if (!$add_dashes) {
        return $password;
    }
    $dash_len = floor(sqrt($length));
    $dash_str = '';
    while (strlen($password) > $dash_len) {
        $dash_str .= substr($password, 0, $dash_len) . '-';
        $password = substr($password, $dash_len);
    }
    $dash_str .= $password;
    return $dash_str;
}

function preSignedUrl($fileName, $type)
{
    $typename = 'pdf/';
    $typeextension = '.pdf';

    if ($type == 0) {
        $typename = 'video/';
        $typeextension = '.mp4';
    }
    $s3 = Storage::disk('s3');
    $generatedFileName = $typename . Str::random(50) . $typeextension;
    $client = $s3->getDriver()->getAdapter()->getClient();
    $expiry = "+1440 minutes";
    $command = $client->getCommand('PutObject', [
        'Bucket' => env('AWS_BUCKET'),
        'Key' => $generatedFileName
    ]);

    $request = $client->createPresignedRequest($command, $expiry);
    $data['url'] = (string)$request->getUri();
    $data['filename'] = $generatedFileName;

    return $data;
}

function paginateCollection($items, $perPage)
{
    if (is_array($items)) {
        $items = collect($items);
    }

    return new \Illuminate\Pagination\LengthAwarePaginator(
        $items->forPage(\Illuminate\Pagination\Paginator::resolveCurrentPage(), $perPage),
        $items->count(),
        $perPage,
        \Illuminate\Pagination\Paginator::resolveCurrentPage(),
        ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
    );
}

function Business($business)
{
    if ($business == '0') {
        return '001';
    }
    if ($business == '1') {
        return '008';
    }
    if ($business == '2') {
        return '004';
    }
    if ($business == '3') {
        return '002';
    }
    if ($business == '4') {
        return '003';
    }
    if ($business == '5') {
        return '023';
    }
    if ($business == '6') {
        return '029';
    }
    if ($business == '7') {
        return '037';
    }
    if ($business == '8') {
        return '009';
    }
    if ($business == '9') {
        return '020';
    }
    if ($business == '10') {
        return '013';
    }
    if ($business == '11') {
        return '040';
    }
    if ($business == '12') {
        return '035';
    }
    if ($business == '13') {
        return '007';
    }
    if ($business == '14') {
        return '026';
    }
    if ($business == '15') {
        return '005';
    }
    if ($business == '16') {
        return '024';
    }
}

function getNameFromCode()
{
    return array(
        '001' => '管理員業務',
        '008' => '日常清掃',
        '004' => '管理委託',
        '002' => '清掃管理業務',
        '003' => '夜間管理業務',
        '023' => '日常清掃及び設備管理要員',
        '029' => 'コンシェル業務',
        '037' => 'サブ管理員業務',
        '009' => '日常清掃②',
        '020' => '管理員業務②',
        '013' => '終了清掃',
        '040' => '管理員業務③',
        '035' => '巡回清掃業務',
        '007' => '巡回管理業務',
        '026' => '夜間管理員',
        '005' => '住み込み管理委託',
        '024' => '日常清掃業務',
    );
}

function businessCategory($businessCategory)
{
    if ($businessCategory == '001') {
        return '001';
    }
    if ($businessCategory == '008') {
        return '008';
    }
    if ($businessCategory == '004') {
        return '004';
    }
    if ($businessCategory == '002') {
        return '002';
    }
    if ($businessCategory == '003') {
        return '003';
    }
    if ($businessCategory == '023') {
        return '023';
    }
    if ($businessCategory == '029') {
        return '029';
    }
    if ($businessCategory == '037') {
        return '037';
    }
    if ($businessCategory == '009') {
        return '009';
    }
    if ($businessCategory == '020') {
        return '020';
    }
    if ($businessCategory == '013') {
        return '013';
    }
    if ($businessCategory == '040') {
        return '040';
    }
    if ($businessCategory == '035') {
        return '035';
    }
    if ($businessCategory == '007') {
        return '007';
    }
    if ($businessCategory == '026') {
        return '026';
    }
    if ($businessCategory == '005') {
        return '005';
    }
    if ($businessCategory == '024') {
        return '024';
    }
}

function getBusinessCategory()
{
    return array(
        '0' => '管理員業務',
        '1' => '日常清掃',
        '2' => '管理委託',
        '3' => '清掃管理業務',
        '4' => '夜間管理業務',
        '5' => '日常清掃及び設備管理要員',
        '6' => 'コンシェル業務',
        '7' => 'サブ管理員業務',
        '8' => '日常清掃②',
        '9' => '管理員業務②',
        '10' => '終了清掃',
        '11' => '管理員業務③',
        '12' => '巡回清掃業務',
        '13' => '巡回管理業務',
        '14' => '夜間管理員',
        '15' => '住み込み管理委託',
        '16' => '日常清掃業務',
    );
}
const RESOURCE_TYPE = [
    1 => 'user',
    2 => 'email',
    3 => 'config',
    4 => 'building',
    5 => 'contractor',
    6 => 'mansion',
    7 => 'guide',
    8 => 'manual',
    9 => 'information-display',
    10 => 'notification'
];

const NO_ACCESS_MSG = 'An error occurred, please try again later!';

function isSameCompany($id, $type): bool
{
    $current_company_id = \Illuminate\Support\Facades\Auth::user()->company_id;
    try {
        switch ($type) {
            case 'user':
                $company_id = \App\User::findOrFail($id)->company_id;
                break;
            case 'config':
                $company_id = \App\Model\Config::findOrFail($id)->company_id;
                break;
            case 'email':
                $company_id = \App\Model\EmailTemplate::findOrFail($id)->company_id;
                break;
            case 'building':
                $buildingAdmin = \App\Model\System\BuildingAdmin::findOrFail($id);
                $company_id = $buildingAdmin->contractor->company_id;
                break;
            case 'contractor':
                $contractor = \App\Model\System\Contractor::findOrFail($id);
                $company_id = $contractor->company->id;
                break;
            case 'mansion':
                $mansion = \App\Model\System\Mansion::findOrFail($id);
                $company_id = $mansion->contractor->company->id;
                break;
            case 'guide':
                $guide = \App\Model\System\Guide::findOrFail($id);
                $company_id = $guide->user->company->id;
                break;
            case 'manual':
                $manual = \App\Model\System\Manual::findOrFail($id);
                $company_id = $manual->company_id;
                break;
            case 'information-display':
                $informationDisplay = \App\Model\System\CheckInCheckOut::findOrFail($id);
                $company_id = $informationDisplay->buildingAdmin->contractor->company_id;
                break;
            case 'notification':
                $notification = \App\Model\System\Notification::findOrFail($id);
                $company_id = $notification->company_id;
                break;
            default:
                return false;
        }
        return $company_id == $current_company_id;
    } catch (Exception $e) {
        return false;
    }
}
