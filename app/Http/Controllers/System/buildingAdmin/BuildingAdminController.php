<?php

namespace App\Http\Controllers\System\buildingAdmin;

use App\Model\System\CheckInCheckOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\System\BuildingAdmin;
use App\Http\Controllers\Controller;
use App\Http\Requests\system\resetPassword;
use App\Services\System\BuildingAdminService;
use App\Http\Controllers\System\ResourceController;

class BuildingAdminController extends ResourceController
{
    public function __construct(BuildingAdminService $buildingAdminService)
    {

        parent::__construct($buildingAdminService);

    }
    public function storeValidationRequest()
    {
        return 'App\Http\Requests\system\BuildingAdminRequest';
    }

    public function updateValidationRequest()
    {
    }

    public function moduleName()
    {

        return 'building';
    }

    public function viewFolder()
    {
        return 'system.buildingAdmin';
    }


    public function passwordReset(resetPassword $request, $id)
    {
        if (!isSameCompany($id, RESOURCE_TYPE[4])) {
            return redirect($this->getUrl())->withErrors(['alert-danger' => translate(NO_ACCESS_MSG)]);
        }
        $this->service->resetPassword($request);
        $user = BuildingAdmin::findorFail($id);
        $client = DB::table('oauth_clients')->where('provider', 'building_admin')->first()->id;
        $access = DB::table('oauth_access_tokens')->where('client_id', $client)->where('user_id',
            $user->id)->latest()->first();

        if ($access != null) {
            if (!$access->revoked) {
                DB::table('oauth_access_tokens')->where('user_id', $user->id)->update([
                    'revoked' => 1,
                    'updated_at' => now()
                ]);
            }
            return redirect($this->getUrl())->withErrors(['success' => translate('Password successfully updated.')]);
        } else {
            return redirect($this->getUrl())->withErrors(['success' => translate('Password successfully updated.')]);
        }
    }

    public function moduleToTitle()
    {

        $title = "";
        $data = explode('-', $this->moduleName());
        foreach ($data as $d) {
            $title .= $d . ' ';
        }
        return ucwords($title . "Admin Management");
    }

    public function tokenReset($id)
    {
        try {
            if (!isSameCompany($id, RESOURCE_TYPE[4])) {
                return redirect($this->getUrl())->withErrors(['alert-danger' => translate(NO_ACCESS_MSG)]);
            }
            $user = BuildingAdmin::findorFail($id);
            $client = DB::table('oauth_clients')->where('provider', 'building_admin')->latest()->first()->id;
            $access = DB::table('oauth_access_tokens')->where('client_id', $client)->where('user_id',
                $user->id)->latest()->first();
            if (!$access->revoked) {
                DB::table('oauth_access_tokens')->where('user_id', $user->id)->update([
                    'revoked' => 1,
                    'updated_at' => now()
                ]);

//                $tokenRepository = app('Laravel\Passport\TokenRepository');
//                $tokenRepository->revokeAccessToken($user->id);
                return redirect($this->getUrl())->withErrors(['success' => translate('Token reset successfully.')]);
            }

            return redirect($this->getUrl())->withErrors(['alert-success' => translate('Token has already been reset.')]);


        } catch (\Exception $e) {
            return redirect($this->getUrl())->withErrors(['alert-danger' => translate('User never logged in before ')]);
        }
    }

    public function show($id)
    {
        try {
            if (!isSameCompany($id, RESOURCE_TYPE[4])) {
                return redirect($this->getUrl())->withErrors(['alert-danger' => translate(NO_ACCESS_MSG)]);
            }
            $data['title'] = translate('Building Admin Management');
            $data['breadcrumbs'] = $this->breadcrumbForIndex();
            $data['items'] = BuildingAdmin::where('id', $id)->first();
            $data['business'] = getBusinessCategory();
//            $data['mansions'] = BuildingAdmin::getMansion();
            return view('system.buildingAdmin.view', $data);
        } catch (\Exception $e) {

        }
    }

    public function edit($id)
    {
        if (!isSameCompany($id, RESOURCE_TYPE[4])) {
            return redirect($this->getUrl())->withErrors(['alert-danger' => translate(NO_ACCESS_MSG)]);
        }
        return parent::edit($id); // TODO: Change the autogenerated stub
    }

    public function update($id)
    {
        if (!isSameCompany($id, RESOURCE_TYPE[4])) {
            return redirect($this->getUrl())->withErrors(['alert-danger' => translate(NO_ACCESS_MSG)]);
        }
        return parent::update($id); // TODO: Change the autogenerated stub
    }

    public function destroy(Request $request, $id)
    {
        if (!isSameCompany($id, RESOURCE_TYPE[4])) {
            return redirect($this->getUrl())->withErrors(['alert-danger' => translate(NO_ACCESS_MSG)]);
        }

        $buildingAdmin = BuildingAdmin::findOrFail($id);
        $checkincheckout = CheckInCheckOut::where('building_admin_id', $id)->count();

        if ($checkincheckout >= 0) {

            $buildingAdmin->checkInCheckOut()->delete();
            $buildingAdmin->delete();
            return redirect($this->getUrl())->withErrors(['success' => translate('Building Admin deleted successfully.')]);
        }
    }
}
